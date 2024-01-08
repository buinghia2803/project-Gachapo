<?php

namespace App\Http\Controllers\Company;

use App\Business\GachaBusiness;
use App\Business\ProductBusiness;
use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Gacha\CreateRequest;
use App\Http\Requests\Company\Gacha\UpdateRequest;
use App\Models\Category;
use App\Models\GachaImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class GachaController extends Controller
{
    public function __construct(
        GachaBusiness $gachaBusiness,
        ProductBusiness $productBusiness
    )
    {
        $this->gachaBusiness = $gachaBusiness;
        $this->productBusiness = $productBusiness;

        $this->status = config('options.gacha_status');
        $this->status[GACHA_DRAF] = 'labels.GAC001_L046';

        $this->status_operation = [
            GACHA_OPERATION_WORK => 'labels.GAC001_L043',
            GACHA_OPERATION_STOP => 'labels.GAC001_L044',
            GACHA_OPERATION_STOP_SALE => 'labels.GAC001_L045',
        ];

        $this->status_apply_discounts = config('options.gacha_status_apply_discounts');

        $this->reward_status = config('options.product_reward_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition =[
            'limit' => GACHA_PER_PAGE,
            'company_id' => Auth::guard(ROLE_COMPANY)->user()->id,
            'order_by' => [
                'fields' => $request->input ?? 'id',
                'sort_type' => $request->typeSort ?? 'desc',
            ]
        ];
        $dataCondition = array_merge($request->all(),$dataCondition);
        if (
            isset($dataCondition['status_operation'])
            && $dataCondition['status_operation'] != null
            && $dataCondition['status_operation'] == GACHA_OPERATION_STOP
        ) {
            $dataCondition['status_operation'] = 'stop';
        }
        $datas = $this->gachaBusiness->list($dataCondition, [ 'images', 'company' ]);

        $status_operation = ['' => '']+$this->status_operation;
        $status = ['' => '']+$this->status;
        return view('company.gachas.index', compact(
            'datas', 'status', 'status_operation'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get()->pluck('name', 'id')->toArray();
        $status_apply_discounts = $this->status_apply_discounts;
        $status_operation = config('options.gacha_status_operation');

        return view('company.gachas.create', compact(
            'categories', 'status_apply_discounts', 'status_operation'
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
            DB::beginTransaction();

            $params = $request->only([
                'name',
                'category_id',
                'selling_price',
                'status_apply_discounts',
                'discounted_price',
                'status_operation',
                'period_start',
                'period_end',
                'description',
                'status',
            ]);
            $params['period_start'] = date('Y-m-d 00:00:00', strtotime($params['period_start']));
            $params['period_end'] = date('Y-m-d 23:59:59', strtotime($params['period_end']));
            $params['company_id'] = Auth::guard(ROLE_COMPANY)->user()->id;
            $params['postage'] = 0;
            $gacha = $this->gachaBusiness->create($params);

            if (!empty($gacha)) {
                // Create Product
                if ($request->hasFile('product_xlsx')) {
                    $productExcel = $request->product_xlsx;
                    $products = \CommonHelper::readExcel($productExcel->getPathName(), [
                        'reward_type' => 2,
                        'name' => 3,
                        'reward_status' => 4,
                        'reward_percent' => 5,
                        'attachment' => 6,
                        'quantity' => 7,
                    ]);
                    unset($products[0]);
                    foreach ($products as $product) {
                        $product['status'] = PRODUCT_STATUS_ACTIVE;
                        $createData = $this->productBusiness->create($gacha->id, $product);
                        if (isset($createData['status']) && $createData['status'] == STATUS_ERROR) {
                            DB::rollBack();
                            return redirect()->back()->withErrors([ 'product_xlsx' => $createData['messages'] ]);
                        }
                    }
                }

                // Create Gacha Image
                $images = $request->images_base64;
                if (!empty($images)) {
                    foreach($images as $image) {
                        if (!empty($image)) {
                            $imageUrl = UploadHelper::doUploadS3Base64($image);
                            GachaImage::create([
                                'gacha_id' => $gacha->id,
                                'attachment' => $imageUrl,
                            ]);
                        }
                    }
                }
                // Return
                DB::commit();
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L005'));
                return redirect()->route('company.gachas.index');
            }

        } catch (\Exception $e) {
            DB::rollBack();
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
        $gacha = $this->gachaBusiness->findById($id)->load('products');
        $products = $gacha->products;
        $rewardStatus = $this->reward_status;
        return view('company.gachas.show', compact(
            'gacha',
            'products',
            'rewardStatus'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        $gacha = $this->gachaBusiness->findById($id)->load('images', 'products');
        $categories = Category::get()->pluck('name', 'id')->toArray();
        $status_apply_discounts = $this->status_apply_discounts;
        $status_operation = config('options.gacha_status_operation');
        return view('company.gachas.edit', compact(
            'gacha',
            'categories',
            'status_apply_discounts',
            'status_operation'
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
            DB::beginTransaction();

            $params = $request->only([
                'name',
                'category_id',
                'selling_price',
                'status_apply_discounts',
                'discounted_price',
                'status_operation',
                'period_start',
                'period_end',
                'description',
                'status',
            ]);
            $params['period_start'] = date('Y-m-d 00:00:00', strtotime($params['period_start']));
            $params['period_end'] = date('Y-m-d 23:59:59', strtotime($params['period_end']));
            $params['postage'] = 0;
            $gacha = $this->gachaBusiness->update($id, $params);

            if (!empty($gacha)) {
                // Create Product
                if ($request->hasFile('product_xlsx')) {
                    $productExcel = $request->product_xlsx;
                    $products = \CommonHelper::readExcel($productExcel->getPathName(), [
                        'reward_type' => 2,
                        'name' => 3,
                        'reward_status' => 4,
                        'reward_percent' => 5,
                        'attachment' => 6,
                        'quantity' => 7,
                    ]);
                    unset($products[0]);
                    foreach ($products as $product) {
                        $product['status'] = PRODUCT_STATUS_ACTIVE;
                        $createData = $this->productBusiness->create($gacha->id, $product);
                        if (isset($createData['status']) && $createData['status'] == STATUS_ERROR) {
                            DB::rollBack();
                            return redirect()->back()->withErrors([ 'product_xlsx' => $createData['messages'] ]);
                        }
                    }
                }

                // Create Gacha Image
                $images = $request->images;
                $imagesBase64 = $request->images_base64;
                $imageChange = $request->change_images;
                if (!empty($images) || $imageChange == SET_AS_AVATAR) {
                    $imageOfGacha = GachaImage::where('gacha_id', $gacha->id)->get();
                    foreach($imageOfGacha as $image) {
                        $image->deleteRecord();
                    }
                    foreach($imagesBase64 as $image) {
                        if (!empty($image)) {
                            $imageUrl = UploadHelper::doUploadS3Base64($image);
                            GachaImage::create([
                                'gacha_id' => $gacha->id,
                                'attachment' => $imageUrl,
                            ]);
                        }
                    }
                }

                // Return
                DB::commit();
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
                return redirect()->route('company.gachas.index');
            }
        } catch (\Exception $e) {
            DB::rollBack();
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
            $this->gachaBusiness->delete($id);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L007'));
            return response()->json('success', STATUS_SUCCESS);
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L010'));
            return response()->json('failure', STATUS_400);
        }
    }

    public function destroyAll(Request $request)
    {
        try {
            \DB::beginTransaction();
            $ids = $request->ids;
            foreach ($ids as $id) {
                $this->gachaBusiness->delete($id);
            }
            \DB::commit();
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L007'));
            return redirect()->route('company.gachas.index');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L010'));
            return redirect()->route('company.gachas.index');
        }
    }

    public function preview(Request $request)
    {
        $gachaID = $request->gacha_id;
        if (!empty($gachaID)) {
            $gacha = $this->gachaBusiness->findById($gachaID)->load('products');
            $productOfGacha = $gacha->products;
        }

        $images = $request->images_base64 ?? [];

        $name = $request->name ?? '';
        $description = $request->description ?? '';

        if ($request->status_apply_discounts == GACHA_APPLY_DISCOUNT) {
            $sellingPrice = number_format($request->discounted_price, 0, '.', ',');
        } else {
            $sellingPrice = number_format($request->selling_price, 0, '.', ',');
        }

        $quantity = 0;
        $products = [];

        if (!empty($productOfGacha)) {
            foreach ($productOfGacha as $item) {
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

        if ($request->hasFile('product_xlsx')) {
            $productExcel = $request->product_xlsx;
            $productData = \CommonHelper::readExcel($productExcel->getPathName(), [
                'reward_type' => 2,
                'name' => 3,
                'reward_status' => 4,
                'reward_percent' => 5,
                'attachment' => 6,
                'quantity' => 7,
            ]);
            unset($productData[0]);
            foreach ($productData as $item) {
                if (!empty($item['reward_type']) && !empty($item['name']) ) {
                    $quantity += $item['quantity'] ?? 0;
                    $item['quantity'] = number_format($item['quantity'] ?? 0, 0, '.', ',');
                    $products[] = $item;
                }
            }
        }
        $products = collect(json_decode(json_encode($products)))->sortBy('reward_type');
        $quantity = number_format($quantity, 0, '.', ',');

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
