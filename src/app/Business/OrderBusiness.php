<?php

namespace App\Business;

use App\Repositories\OrderRepository;
use App\Repositories\ReviewRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderBusiness extends BaseBusiness
{
  protected OrderRepository $orderRepository;
  protected ReviewRepository $reviewRepository;

  public function __construct(
    OrderRepository $orderRepository,
    ReviewRepository $reviewRepository
  ) {
    parent::__construct($orderRepository);
    $this->reviewRepository = $reviewRepository;
  }

  /**
   * Get order list.
   *
   * @param  mixed $conditions
   *
   * @return  Collection $entities
   */
  public function list($conditions, $relations = [], $selectable = [], $relationCounts = [])
  {
    return $this->repository->list($conditions, [
      'gacha',
      'gacha.images',
      'gacha.products' => function ($query) {
        $query->select('id', 'quantity', 'gacha_id');
      }
    ]);
  }

  /**
   * Get order detail
   *
   * @param  mixed $detail
   */
  public function detail($id)
  {
    return $this->repository->findByCondition(['id' => $id])->with([
      'gacha', 'gacha.images',
      'review' => function ($query) use ($id) {
        return $query->select(
          '*',
          DB::raw("(select company from companies where id = (select company_id from gachas where id = (select gacha_id from orders where id = $id))) as company_name"),
          DB::raw("(select company_furigana from companies where id = (select company_id from gachas where id = (select gacha_id from orders where id = $id))) as company_furigana")
        );
      }
    ])->first();
  }


  /**
   * Create review for order
   */
  public function createReview($data)
  {
    if (!isset($data['content_reply'])) {
      $data['content_reply'] = '';
    }
    if (!isset($data['status'])) {
      $data['status'] = NOT_APPROVED_REVIEW;
    }

    return $this->reviewRepository->create($data);
  }

  /**
   * get order by user id
   * 
   * @param Array $input
   * 
   * @return mixed
   */
  public function getOrderByUserId($input)
  {
    $order = $this->reviewRepository->getOrderByUserId($input['user_id']);
    return $order;
  }

  public function isShowChart($data)
  {
    $isShow = false;
    foreach ($data['data'] as $value) {
      if ($value != 0) {
        $isShow = true;
        break;
      }
    }
    return $isShow;
  }
}
