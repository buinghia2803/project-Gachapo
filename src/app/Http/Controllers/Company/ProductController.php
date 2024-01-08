<?php

namespace App\Http\Controllers\Company;

use App\Business\GachaBusiness;
use App\Business\ProductBusiness;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Product\CreateRequest;
use App\Http\Requests\Company\Product\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function __construct(
        GachaBusiness $gachaBusiness,
        ProductBusiness $productBusiness
    )
    {
        $this->gachaBusiness = $gachaBusiness;
        $this->productBusiness = $productBusiness;

        $this->reward_status = config('options.product_reward_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $gachaID = $request->gacha_id;
        if (empty($gachaID)) {
            return redirect()->back();
        }

        $gacha = $this->gachaBusiness->findById($gachaID);
        $rewardStatus = $this->reward_status;
        unset($rewardStatus[PRODUCT_REWARD_NONE]);

        return view('company.products.create', compact(
            'gacha',
            'rewardStatus'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        try {
            $gachaID = $request->gacha_id;
            if (empty($gachaID)) {
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
                return redirect()->back();
            }

            $params = $request->only([
                'reward_type',
                'name',
                'reward_status',
                'reward_percent',
                'quantity',
                'attachment',
                'attachment_base64',
                'status',
            ]);
            $product = $this->productBusiness->create($gachaID, $params);
            if ($product['status'] == STATUS_ERROR && $product['status_type'] == REWARD_TYPE) {
                return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors(['reward_type' => __('messages.GAC001_L003')]);
            }
            if ($product['status'] == STATUS_ERROR && $product['status_type'] == REWARD_PERCENT) {
                return redirect()->back()
                            ->withInput($request->all())
                            ->withErrors(['reward_percent' => __('messages.GAC001_L005')]);
            }

            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L005'));
            return redirect()->route('company.gachas.show', $gachaID);
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->productBusiness->findById($id)->load('gacha');
        $gacha = $product->gacha;
        $rewardStatus = $this->reward_status;
        unset($rewardStatus[PRODUCT_REWARD_NONE]);

        return view('company.products.edit', compact(
            'product',
            'gacha',
            'rewardStatus'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        try {
            $gachaID = $request->gacha_id;
            if (empty($gachaID)) {
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
                return redirect()->back();
            }

            $params = $request->only([
                'reward_type',
                'name',
                'reward_status',
                'reward_percent',
                'quantity',
                'attachment',
                'attachment_base64',
                'status',
            ]);
            $product = $this->productBusiness->update($id, $gachaID, $params);
            if ($product['status'] == STATUS_ERROR && $product['status_type'] == REWARD_TYPE) {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors(['reward_type' => __('messages.GAC001_L003')]);
            }
            if ($product['status'] == STATUS_ERROR && $product['status_type'] == REWARD_PERCENT) {
                return redirect()->back()
                    ->withInput($request->all())
                    ->withErrors(['reward_percent' => __('messages.GAC001_L005')]);
            }

            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->route('company.gachas.show', $gachaID);
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $this->productBusiness->delete($id);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L007'));
            return response()->json('success', STATUS_SUCCESS);
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L035'));
            return response()->json('failure', STATUS_400);
        }
    }

    public function destroyAll(Request $request)
    {
        try {
            \DB::beginTransaction();
            $ids = $request->ids;
            foreach ($ids as $id) {
                $this->productBusiness->delete($id);
            }
            \DB::commit();
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L007'));
            return redirect()->back();
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L010'));
            return redirect()->back();
        }
    }

    public function preview(Request $request)
    {
        $gachaID = $request->gacha_id;
        $productID = $request->product_id;
        $gacha = $this->gachaBusiness->findById($gachaID)->load('images', 'products');

        $productOfGacha = $gacha->products;

        $quantity = 0;
        $products = [];
        if (!empty($productOfGacha)) {
            foreach ($productOfGacha as $item) {
                if ($productID == $item->id) {
                    $quantity += $request->quantity ?? 0;
                    $products[] = [
                        'reward_type' => $request->reward_type,
                        'name' => $request->name,
                        'reward_status' => $request->reward_status,
                        'reward_percent' => $request->reward_percent,
                        'attachment' => $request->attachment_base64 ?? $request->attachment_input ?? '',
                        'quantity' => number_format($request->quantity ?? 0, 0, '.', ','),
                    ];
                } else {
                    $quantity += $item->quantity ?? 0;
                    $products[] = [
                        'reward_type' => $item->reward_type,
                        'name' => $item->name,
                        'reward_status' => $item->reward_status,
                        'reward_percent' => $item->reward_percent,
                        'attachment' => $item->getImage(),
                        'quantity' => number_format($item->quantity ?? 0, 0, '.', ','),
                    ];
                }
            }
        }

        if (empty($productID)) {
            $rewardType = $request->reward_type ?? null;
            $name = $request->name ?? null;
            if (!empty($rewardType) && !empty($name) ) {
                $quantity += $request->quantity ?? 0;
                $products[] = [
                    'reward_type' => $rewardType,
                    'name' => $name,
                    'reward_status' => $request->reward_status,
                    'reward_percent' => $request->reward_percent,
                    'attachment' => $request->attachment_base64,
                    'quantity' => number_format($request->quantity ?? 0, 0, '.', ','),
                ];
            }
        }

        $name = $gacha->name;
        $images = $gacha->images->map(function ($row) {
            $row['attachment'] = $row->getImage();
            return $row;
        })->pluck('attachment')->toArray();
        $description = $gacha->description;
        $quantity = number_format($quantity, 0, '.', ',');
        if ($gacha->status_apply_discounts == GACHA_APPLY_DISCOUNT) {
            $sellingPrice = number_format($gacha->discounted_price, 0, '.', ',');
        } else {
            $sellingPrice = number_format($gacha->selling_price, 0, '.', ',');
        }
        $products = collect(json_decode(json_encode($products)))->sortBy('reward_type');

        $html = view('company.components.modal.preview-gacha', compact(
            'images',
            'name',
            'description',
            'quantity',
            'sellingPrice',
            'products'
        ))->render();
        return [
            'status' => STATUS_SUCCESS,
            'html' => $html
        ];
    }
}
