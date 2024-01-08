<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\Page\CreateRequest;
use App\Http\Requests\Admin\Page\UpdateRequest;
use App\Business\PageBusiness;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    protected PageBusiness $pageBusiness;

    public function __construct(PageBusiness $pageBusiness)
    {
        $this->pageBusiness = $pageBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition =[
            'limit' => STATIC_PAGE_PER_PAGE
        ];
        $dataCondition = array_merge($request->all() ,$dataCondition);

        $pages = $this->pageBusiness->list($dataCondition);
        $params = $request->all();
        $statusList = $this->pageBusiness->getStatusList();
        $typeList = $this->pageBusiness->getTypeList();
        $checkUnusedType = count($this->pageBusiness->getUnusedTypeList());

        if ($pages->currentPage() > $lastPage = $pages->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return redirect()->route('admin.page.index', compact('params', 'statusList', 'typeList', 'checkUnusedType'));
        }

        return view('admin.page.index', compact('pages', 'params', 'statusList', 'typeList', 'checkUnusedType'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $statusList = $this->pageBusiness->getStatusList();
        $listUnusedType = $this->pageBusiness->getUnusedTypeList();

        return view('admin.page.create', compact('statusList', 'listUnusedType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        if ($this->pageBusiness->create($request->onlyFields())) {
            return redirect()->route('admin.pages.index')->with([
                'success' => __('messages.CM001_L005'),
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'error' => __('messages.CM001_L003'),
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
        $page = $this->pageBusiness->findById($id);
        $typeList = $this->pageBusiness->getTypeList();
        $statusList = $this->pageBusiness->getStatusList();
        $listUnusedType = $this->pageBusiness->getUnusedTypeList();
        $listUnusedType[$page->type] = $typeList[$page->type];

        return view('admin.page.edit', compact('page', 'statusList', 'listUnusedType', 'typeList'));
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
        if ($this->pageBusiness->update($id, $request->onlyFields())) {
            return redirect()->route('admin.pages.index')->with([
                'success' => __('messages.CM001_L006'),
            ]);
        }

        return redirect()->route('admin.pages.index')->with([
            'error' => __('messages.CM001_L003'),
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
            if ($this->pageBusiness->delete($id)) {
                Session::put('deleted_success', true);

                return response()->json('success', 200);
            } else {
                Session::put('deleted_failed', true);
                return response()->json('failure', 400);
            }
        } catch (\Exception $e) {
            Session::put('deleted_failed', true);
            \Log::error($e);
            return response()->json('failure', 400);
        }
    }
}
