<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BannerMainVisual\CreateRequest;
use App\Http\Requests\Admin\BannerMainVisual\UpdateRequest;
use App\Business\BannerBusiness;

class BannerMainVisualController extends Controller
{
    public function __construct(
        BannerBusiness $bannerBusiness
    )
    {
        $this->bannerBusiness = $bannerBusiness;
    }

    /**
     *
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = $this->bannerBusiness->getlistMainVisual();
        return view('admin.banner-main-visuals.index', compact(
            'datas'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banners = $this->bannerBusiness->getlistMainVisual();
        if ($banners->count() >= BANNER_MAX_IN_LIST) {
            return redirect()->route('admin.banner-main-visuals.index');
        }
        return view('admin.banner-main-visuals.create');
    }

    public function createConfirm(CreateRequest $request)
    {
        $banners = $this->bannerBusiness->getlistMainVisual();
        if ($banners->count() >= BANNER_MAX_IN_LIST) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->route('admin.banner-main-visuals.index');
        }
        extract($request->all(), EXTR_OVERWRITE);
        return view('admin.banner-main-visuals.create-confirm', compact(
            'title', 'link', 'attachment_base64'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $banners = $this->bannerBusiness->getlistMainVisual();
        if ($banners->count() >= BANNER_MAX_IN_LIST) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->route('admin.banner-main-visuals.index');
        }
        try {
            $this->bannerBusiness->createMainVisual($request->only(['title', 'link', 'attachment']));
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L005'));
            return redirect()->route('admin.banner-main-visuals.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->route('admin.banner-main-visuals.index');
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
        $data = $this->bannerBusiness->findById($id);
        return view('admin.banner-main-visuals.edit', compact('data'));
    }

    public function updateConfirm(UpdateRequest $request, $id)
    {
        extract($request->all(), EXTR_OVERWRITE);
        $data = $this->bannerBusiness->findById($id);
        return view('admin.banner-main-visuals.edit-confirm', compact(
            'data', 'title', 'link', 'attachment_base64', 'attachment_input'
        ));
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
        try {
            $this->bannerBusiness->updateMainVisual($id, $request->only(['title', 'link', 'attachment']));
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->route('admin.banner-main-visuals.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->route('admin.banner-main-visuals.index');
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
            if ($this->bannerBusiness->delete($id)) {
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L007'));
                return response()->json('success', 200);
            } else {
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L010'));
                return response()->json('failure', 400);
            }
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L010'));
            return response()->json('failure', 400);
        }
    }
}
