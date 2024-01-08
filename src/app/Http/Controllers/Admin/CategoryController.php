<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\CategoryBusiness;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected CategoryBusiness $categoryBusiness;

    public function __construct(
        CategoryBusiness $categoryBusiness
    )
    {
        $this->categoryBusiness = $categoryBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition =[
            'limit' => CATEGORY_PER_PAGE
        ];
        $dataCondition = array_merge($request->all() ,$dataCondition);

        $categories = $this->categoryBusiness->list($dataCondition);
        $params = $request->all();
        if ($categories->currentPage() > $lastPage = $categories->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return redirect()->route('admin.category.index', $params);
        }

        return view('admin.category.index', compact('categories', 'params'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        if ($this->categoryBusiness->create($request->onlyFields())) {
            return redirect()->route('admin.category.index')->with([
                'success' => __('messages.CM001_L005'),
            ]);
        }

        return redirect()->route('admin.category.index')->with([
            'error' => __('messages.CT_MSG009'),
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
        $category = $this->categoryBusiness->findById($id);

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {
        if ($this->categoryBusiness->update($id, $request->onlyFields())) {
            return redirect()->route('admin.category.index')->with([
                'success' => __('messages.CM001_L006'),
            ]);
        }

        return redirect()->route('admin.category.index')->with([
            'error' => __('messages.CT_MSG010'),
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
            if ($this->categoryBusiness->delete($id)) {
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
