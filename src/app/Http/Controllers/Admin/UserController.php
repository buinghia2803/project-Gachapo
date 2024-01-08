<?php

namespace App\Http\Controllers\Admin;

use App\Business\UserBusiness;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\CreateUserRequest;
use App\Http\Requests\Admin\User\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;

class UserController extends Controller
{
    protected UserBusiness $userBusiness;

    public function __construct(
        UserBusiness $userBusiness
    )
    {
        $this->userBusiness = $userBusiness;
        view()->share([
            'activeUser' => true,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $dataCondition =[
            'limit' => USER_PER_PAGE
        ];
        $dataCondition = array_merge($request->all() ,$dataCondition);

        $users = $this->userBusiness->list($dataCondition);
        $params = $request->all();
        $listStatus = $this->userBusiness->getListStatus();
        if ($users->currentPage() > $lastPage = $users->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return redirect()->route('admin.user.index', compact('params', 'listStatus'));
        }

        return view('admin.user.index', compact('users', 'params', 'listStatus'));
    }

    /**
     * Export CSV list user by conditions.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFile(Request $request)
    {
        $users = $this->userBusiness->findByCondition($request->only(['id', 'name', 'status', 'address']), [],
            ['id', 'name', 'email', 'address_first', 'status'])->get();
        $listStatus = $this->userBusiness->getListStatus();

        return Excel::download(new UserExport($users, $listStatus), 'users.csv');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function create(Request $request)
    {
        $listStatus = $this->userBusiness->getListStatus();

        return view('admin.user.create', compact('listStatus'));
    }

    /**
     * Verify a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyCreate(CreateUserRequest $request)
    {
        $listStatus = $this->userBusiness->getListStatus();
        $data = $request->onlyFields();

        return view('admin.user.verify-create', compact('listStatus', 'data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $this->userBusiness->create($input);

        return redirect()->route('admin.user.index')->with([
            'success' => __('messages.CM001_L005'),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function edit($id)
    {
        $user = $this->userBusiness->findById($id);
        $listStatus = $this->userBusiness->getListStatus();

        return view('admin.user.edit', compact('user', 'listStatus'));
    }

     /**
     * show verification screen
     *
     * @param  \Illuminate\Http\UpdateRequest  $request
     * @return view
     */
    public function verifyUpdate(UpdateRequest $request)
    {
        $data = $request->all();
        $listStatus = $this->userBusiness->getListStatus();

        return view('admin.user.verify-update', compact('data', 'listStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(Request $request, $id)
    {
        $this->userBusiness->update($id, $request->all());

        return redirect()->route('admin.user.index')->with([
            'success' => __('messages.CM001_L006'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        try {
            if ($this->userBusiness->delete($id)) {
                Session::put('deleted_success', true);

                return response()->json('success', 200);
            } else {
                Session::put('deleted_failed', true);
                return response()->json('failure', 400);
            }
        } catch (\Exception $e) {
            Session::put('deleted_failed', true);
            Log::error($e);
            throw $e;
        }
    }
}
