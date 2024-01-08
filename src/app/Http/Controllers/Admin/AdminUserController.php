<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Admin\CreateRequest;
use App\Http\Requests\Admin\Admin\UpdateRequest;
use App\Business\AdminUserBusiness;

class AdminUserController extends Controller
{

    public function __construct(
        AdminUserBusiness $adminBusiness
    )
    {
        $this->adminBusiness = $adminBusiness;

        $this->status = config('options.admin_status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition =[
            'limit' => ADMIN_PER_PAGE,
            'order_by' => [
                'fields' => $request->input ?? 'id',
                'sort_type' => $request->typeSort ?? 'desc',
            ]
        ];
        $dataCondition = array_merge($request->all() ,$dataCondition);
        $datas = $this->adminBusiness->list($dataCondition);

        $status = $this->status;
        return view('admin.admin_users.index', compact(
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
        $status = $this->status;
        return view('admin.admin_users.create', compact(
            'status'
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
            $this->adminBusiness->createRecord($request->onlyFields());
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L005'));
            return redirect()->route('admin.admin_users.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L003'));
            return redirect()->route('admin.admin_users.index');
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
        $data = $this->adminBusiness->findById($id);
        $status = $this->status;
        return view('admin.admin_users.edit', compact(
            'data', 'status'
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
            $this->adminBusiness->updateRecord($id, $request->onlyFields());
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->route('admin.admin_users.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->route('admin.admin_users.index');
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
            if ($this->adminBusiness->delete($id)) {
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L007'));
                return response()->json('success', 200);
            } else {
                \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.ADM001_MSG002'));
                return response()->json('failure', 400);
            }
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L003'));
            return response()->json('failure', 400);
        }
    }
}
