<?php

namespace App\Http\Controllers\Company;
use App\Business\NotificationBusiness;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
            'limit' => ADMIN_PER_PAGE,
            'is_published' => PUBLISH,
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);

        $notifies = $this->notifyBusiness->list($dataCondition);
        $params = $request->all();
        if ($notifies->currentPage() > $lastPage = $notifies->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return redirect()->route('company.notify.index', compact('params'));
        }

        return view('company.notify.index', compact('notifies', 'params'));
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
        $notify = $this->notifyBusiness->getNotifyDetail($id);

        return view('company.notify.show', compact('notify'));
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
}
