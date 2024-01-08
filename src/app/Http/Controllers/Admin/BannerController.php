<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\BannerMainVisual\CreateRequest;
use App\Http\Requests\Admin\BannerMainVisual\UpdateRequest;
use App\Business\BannerBusiness;

class BannerController extends Controller
{
    public function __construct(
        BannerBusiness $bannerBusiness
    )
    {
        $this->bannerBusiness = $bannerBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = $this->bannerBusiness->getlistNormal();
        $show_type = $this->bannerBusiness->getShowType();
        return view('admin.banners.index', compact(
            'datas', 'show_type'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banners = $this->bannerBusiness->getlistNormal();
        if ($banners->count() >= BANNER_MAX_IN_LIST) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->route('admin.banners.index');
        }
        return view('admin.banners.create');
    }

    public function createConfirm(CreateRequest $request)
    {
        $banners = $this->bannerBusiness->getlistNormal();
        if ($banners->count() >= BANNER_MAX_IN_LIST) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->route('admin.banners.index');
        }
        extract($request->all(), EXTR_OVERWRITE);
        return view('admin.banners.create-confirm', compact(
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
        $banners = $this->bannerBusiness->getlistNormal();
        if ($banners->count() >= BANNER_MAX_IN_LIST) {
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->route('admin.banners.index');
        }
        try {
            $this->bannerBusiness->createNormal($request->only(['title', 'link', 'attachment']));
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L005'));
            return redirect()->route('admin.banners.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L008'));
            return redirect()->route('admin.banners.index');
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
        return view('admin.banners.edit', compact('data'));
    }

    public function updateConfirm(UpdateRequest $request, $id)
    {
        extract($request->all(), EXTR_OVERWRITE);
        $data = $this->bannerBusiness->findById($id);
        return view('admin.banners.edit-confirm', compact(
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
            $this->bannerBusiness->updateNormal($id, $request->only(['title', 'link', 'attachment']));
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->route('admin.banners.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->route('admin.banners.index');
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

    /**
     * Update option type_show_banner
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateShowType(Request $request)
    {
        try {
            \App\Models\Option::where('key', 'type_show_banner')->update([
                'value' => $request->show_type
            ]);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->route('admin.banners.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->route('admin.banners.index');
        }
    }
}
