<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\GachaBusiness;

class GachaController extends Controller
{
    public function __construct(
        GachaBusiness $gachaBusiness
    )
    {
        $this->gachaBusiness = $gachaBusiness;

        $this->status = config('options.gacha_status');
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
            'order_by' => [
                'fields' => $request->input ?? 'id',
                'sort_type' => $request->typeSort ?? 'desc',
            ]
        ];
        $dataCondition = array_merge($request->all() ,$dataCondition);
        $datas = $this->gachaBusiness->list($dataCondition, [ 'images', 'company' ]);

        $status = ['' => '']+$this->status;
        return view('admin.gachas.index', compact(
            'datas', 'status'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $gacha = $this->gachaBusiness->findById($id)->load('company', 'products');
        $products = $gacha->products;
        $rewardStatus = $this->reward_status;
        return view('admin.gachas.show', compact(
            'gacha', 'products', 'rewardStatus'
        ));
    }

    /**
     * Approve Data
     */
    public function approve(Request $request, $id)
    {
        try {
            $this->gachaBusiness->update($id, [
                'status' => GACHA_APPROVED,
                'reject_reason' => null,
            ]);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L019'));
            return redirect()->route('admin.gachas.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L020'));
            return redirect()->route('admin.gachas.index');
        }
    }

    /**
     * Disapprove Data
     */
    public function disapprove(Request $request, $id)
    {
        try {
            $this->gachaBusiness->update($id, [
                'status' => GACHA_DISAPPROVED,
                'reject_reason' => $request->reject_reason,
            ]);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L021'));
            return redirect()->route('admin.gachas.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L022'));
            return redirect()->route('admin.gachas.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Remove all the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            return redirect()->route('admin.gachas.index');
        } catch (\Exception $e) {
            \DB::rollback();
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L010'));
            return redirect()->route('admin.gachas.index');
        }
    }

    /**
     * Update recommend at gacha.
     */
    protected function updateRecommend(Request $request, $id)
    {
        try {
            $recommend = ($request->recommend == 'on') ? GACHA_RECOMMEND_TRUE : GACHA_RECOMMEND_FALSE;
            $this->gachaBusiness->update($id, [
                'recommend' => $recommend,
            ]);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->back();
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->back();
        }
    }

    /**
     * Confirm of gacha.
     */
    public function confirm(Request $request, $id)
    {
        $gacha = $this->gachaBusiness->findById($id)->load('company', 'products', 'images', 'category');
        return view('admin.gachas.confirm', compact(
            'gacha'
        ));
    }
}
