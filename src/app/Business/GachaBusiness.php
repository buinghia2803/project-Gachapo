<?php

namespace App\Business;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Gacha;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Favorite;
use App\Repositories\GachaRepository;

use App\Services\StripeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GachaBusiness extends BaseBusiness
{
  protected GachaRepository $gachaRepository;
  protected OrderBusiness $orderBusiness;
  protected ReviewBusiness $reviewBusiness;
  protected StripeService $stripeService;
  protected OrderDetailBusiness $orderDetailBusiness;

  public function __construct(
    GachaRepository $gachaRepository,
    OrderBusiness $orderBusiness,
    StripeService $stripeService,
    ReviewBusiness $reviewBusiness,
    OrderDetailBusiness $orderDetailBusiness
  ) {
    parent::__construct($gachaRepository);
    $this->gachaRepository = $gachaRepository;
    $this->orderBusiness = $orderBusiness;
    $this->reviewBusiness = $reviewBusiness;
    $this->orderDetailBusiness = $orderDetailBusiness;
    $this->stripeService = $stripeService;
  }

  /**
   * Get list data with relation.
   */
  public function list($conditions, $relations = [], $selectable = [], $relationCounts = [])
  {
    $prodSelectable = ['id', 'quantity', 'gacha_id', 'reward_status'];
    $imageSelectable = ['id', 'gacha_id', 'attachment'];

    $list =  $this->repository->list($conditions, [
      'products' => function ($query) use ($prodSelectable) {
        return $query->select($prodSelectable);
      },
      'images' => function ($query) use ($imageSelectable) {
        return $query->select($imageSelectable)->orderBy('updated_at', DESC)->limit(1);
      },
    ], $selectable, $relationCounts);

    return $list;
  }

  /**
   * Event unlike gacha.
   * @param array $conds
   *
   * @return boolean
   */
  public function getListGachaReview($id, $conds)
  {
    $data = [];
    $orderIds = Order::where('gacha_id', $id)->pluck('id')->toArray();
    $selectable = [
      'id',
      'order_id',
      'content',
      'rating',
      'content_reply',
      'date_reply',
      'status',
      DB::raw("(select company from companies where id = (select company_id from gachas where id = $id)) as company_name"),
      DB::raw("(select company_furigana from companies where id = (select company_id from gachas where id = $id)) as company_furigana")
      // 'created_at',
      // 'updated_at'
    ];
    $avgRating = DB::table('reviews')->selectRaw(DB::raw('AVG(rating) as rating_avg'))->whereIn('order_id', $orderIds)->first();
    if (!empty($orderIds)) {
      $data = $this->reviewBusiness->findByCondition([
        'order_ids' => $orderIds
      ], [], $selectable)->paginate($conds['limit']);
    }

    return ['avg_rating' => $avgRating->rating_avg, 'data' => $data];
  }

  /**
   * Get gacha by id with 1 image newest.
   * @param App\Models\Gacha $gacha
   *
   * @return Collection
   */
  public function getGachaById($id)
  {
    $selectable = [
      'id',
      'name',
      'category_id',
      'company_id',
      'selling_price',
      'discounted_price',
      'discounted_percent',
      'postage',
      'status_apply_discounts',
      'status_operation',
      'status',
      'period_start',
      'period_end',
      'description',
      DB::raw("(select AVG(CAST(rating as DECIMAL(2,1))) from `reviews` where `reviews`.`order_id` in (SELECT id FROM orders WHERE gacha_id = $id)) as rating_avg")
    ];

    $gacha = Gacha::find($id, $selectable)
      ->load([
        'images' => function ($query) {
          return $query->select('id', 'gacha_id', 'attachment')->orderBy('updated_at', DESC)->limit(1);
        },
        'favorites' => function ($query) {
          return $query->select('id', 'user_id', 'gacha_id');
        },
        'products' => function ($query) {
          $query->select([
            'id', 'gacha_id', 'name', 'quantity', 'attachment',
            'reward_percent', 'reward_type', 'reward_status', 'status'
          ])->orderBy('reward_type', 'asc');
        }
      ])
      ->loadCount([
        'orders as review_count' => function ($query) {
          return $query->has('review');
        }
      ]);

    return $gacha;
  }

  /**
   * Event like gacha.
   * @param array $conds
   *
   * @return boolean
   */
  public function eventLikeGacha($conds)
  {
    return $this->repository->eventLikeGacha($conds);
  }

  /**
   * Event buy gacha.
   * @param array $conds
   *
   * @return boolean
   */
  public function buyGacha($gacha, $conds)
  {
    DB::beginTransaction();
    try {
      if (isset($conds['coupon_code']) && $conds['coupon_code']) {
        $coupon = Coupon::where('code', $conds['coupon_code'])->first();
        if (!$coupon) throw new \Exception("Don't find coupon with coupon name! Please try again!");
      }

      $user = User::find($conds['user_id'])->load('creditCard');
      $couponPrice = 0;
      if ($coupon) {
        $couponPrice = $coupon->type_discount == COUPON_TYPE_PERCENT ?  $gacha->selling_price * ($coupon->discount_rate / 100) : $coupon->discount_amount;
      }
      $data = [
        'gacha_id' => $gacha->id,
        'user_id' => $conds['user_id'],
        'coupon_id' => $coupon->id ?? null,
        'coupon_price' => $coupon->price ?? 0,
        'quantity' => $conds['quantity'],
        'gacha_price' => $gacha->selling_price,
        'address_delivery' => $user->address_type == ADDRESS_TYPE_FIRST ? $user->address_first : $user->address_second,
        'status_deliver' => DEFAULT_STATUS_DELIVERY,
        'date_of_shipment' => Carbon::now()->addDays(DEFAULT_TIME_SHIPMENT) // TODO: 7 before create order.
      ];
      $order =  $this->orderBusiness->create($data);

      // create a payment
      $paymentInfo = [
        'amount' => $gacha->selling_price *  $conds['quantity'] - $couponPrice ?? 0,
        'customer_id' => $user->customer_id ?? '',
        'card_id' => $user->creditCard->stripe_card_id ?? '',
      ];
      $this->stripeService->createChargeStripe($paymentInfo);

      // Lucky draw or distribution
      $gacha->load('products');
      $result = [];
      for ($i = 0; $i < $conds['quantity']; $i++) {
        $prize = $this->luckyDraw($gacha->products);
        array_push($result, $prize);
        $this->orderDetailBusiness->create([
          'order_id' => $order->id,
          'product_id' => $prize['id'] ?? 0
        ]);
      }

      $result = collect($result)->groupBy('reward_type')->toArray();
      DB::commit();

      return $result;
    } catch (\Exception $e) {
      DB::rollBack();
      Log::error('[GachaBusiness->buyGacha:' . __LINE__ . '] ' . $e->getMessage());
      throw new \Exception($e->getMessage());
    }
  }

  /**
   * Lucky draw.
   * @param collection $products
   * @return collection
   */
  public function luckyDraw($products)
  {
    try {
      $array = [];
      $selectable = ['id', 'name', 'attachment', 'reward_type'];
      foreach ($products as $product) {
        if ($product->reward_status == REWARD_STATUS_QUANTITY) {
          $quantiyPrecent = ($product->reward_percent * $product->quantity) / 100;
          if ($quantiyPrecent >= 1) {
            $array = array_merge(array_fill(0, $quantiyPrecent, $product->only($selectable)), $array);
          } else {
            $newArr = array_fill(0, $product->quantity, $product->only($selectable));
            $division = round(1 / $quantiyPrecent);
            for ($i = 0; $i < $division; $i++) {
              $newArr = array_merge($newArr, array_fill(0, $product->quantity, null));
            }
            $reward = collect($newArr)->shuffle()->random();
            if ($reward) {
              array_push($array, $reward);
            }
          }
        } else {
          $array = array_merge(array_fill(0, $product->reward_percent, $product->only($selectable)), $array);
        }
      }
      shuffle($array);

      return collect($array)->random();
    } catch (\Exception $e) {
      throw new \Exception($e->getMessage());
    }
  }

  /**
   * Event unlike gacha.
   * @param array $conds
   *
   * @return boolean
   */
  public function eventUnLikeGacha($conds)
  {
    return $this->repository->eventUnLikeGacha($conds);
  }

  /**
   * Event gacha favorite by user id.
   * @param array $conds
   *
   * @return boolean
   */
  public function getListGachaFavoritesByUserId($data)
  {
    $userId = auth()->guard('api')->user()->id;

    if ($userId) {
      $data['ids'] = Favorite::where('user_id', $userId)->pluck('gacha_id')->toArray();

      if (count($data['ids'])) {
        return $this->repository->list($data, [
          'images' => function ($query) {
            $query->select('id', 'gacha_id', 'attachment')->orderBy('updated_at', DESC)->limit(1);
          },
          'products' => function ($query) {
            $query->select('id', 'gacha_id', 'quantity');
          }
        ]);
      }
    } else {
      return [];
    }
  }
}
