<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\NotificationBusiness;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\Notifications\CreateNotificationRequest;
use App\Http\Requests\Admin\Notifications\UpdateNotificationRequest;

class NotificationController extends Controller
{
    protected NotificationBusiness $notifyBusiness;

    public function __construct(NotificationBusiness $notifyBusiness)
    {
        $this->notifyBusiness = $notifyBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition = [
            'limit' => NOTIFY_PER_PAGE
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);

        $notifies = $this->notifyBusiness->list($dataCondition);
        $params = $request->all();
        $listStatus = $this->notifyBusiness->getListStatus();
        if ($notifies->currentPage() > $lastPage = $notifies->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return redirect()->route('admin.notify.index', compact('params', 'listStatus'));
        }

        return view('admin.notify.index', compact('notifies', 'params', 'listStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listStatus = $this->notifyBusiness->getListStatus();
        $listType = $this->notifyBusiness->getListType();
        return view('admin.notify.create', compact('listStatus', 'listType'));
    }

    public function verification(CreateNotificationRequest $request)
    {
        $data = $this->notifyBusiness->getConfirmData($request->all());
        $listStatus = $this->notifyBusiness->getListStatus();
        $listType = $this->notifyBusiness->getListType();

        return view('admin.notify.verification', compact('data', 'listType', 'listStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->notifyBusiness->create($request->all());

        return redirect()->route('admin.notify.index')->with([
            'success' => __('messages.CM001_L005'),
        ]);
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
        $notify = $this->notifyBusiness->findById($id);
        $listType = $this->notifyBusiness->getListType();

        return view('admin.notify.edit', compact('notify', 'listType'));
    }

    public function updateVerification(UpdateNotificationRequest $request)
    {
        $data = $this->notifyBusiness->getConfirmData($request->all());
        $listStatus = $this->notifyBusiness->getListStatus();
        $listType = $this->notifyBusiness->getListType();

        return view('admin.notify.update-verification', compact('data', 'listType', 'listStatus'));
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
        $this->notifyBusiness->update($id, $request->all());

        return redirect()->route('admin.notify.index')->with([
            'success' => __('messages.CM001_L006'),
        ]);
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
            if ($this->notifyBusiness->delete($id)) {
                Session::put('deleted_success', true);

                return response()->json('success', 200);
            } else {
                Session::put('deleted_failed', true);
                return response()->json('failure', 400);
            }
        } catch (\Exception $e) {
            Session::put('deleted_failed', true);
            \Log::error($e);
            throw $e;
        }
    }
}
