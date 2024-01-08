<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Business\CompanyBusiness;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CompanyExport;
use App\Http\Requests\Admin\Company\CreateRequest;
use App\Http\Requests\Admin\Company\UpdateRequest;
use App\Jobs\SendMailTemplate;

class CompanyController extends Controller
{
    protected CompanyBusiness $companyBusiness;

    public function __construct(CompanyBusiness $companyBusiness)
    {
        $this->companyBusiness = $companyBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition = [
            'limit' => COMPANY_PER_PAGE,
            'default_conds' => 1
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);

        $companies = $this->companyBusiness->list($dataCondition);
        $params = $request->all();
        $listStatus = $this->companyBusiness->getListStatus();
        if ($companies->currentPage() > $lastPage = $companies->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return redirect()->route('admin.company.index', compact('params', 'listStatus'));
        }

        return view('admin.company.index', compact('companies', 'params', 'listStatus'));
    }

    /**
     * Export list company by conditions.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFile(Request $request)
    {
        $conds = array_merge(['default_conds' => 1], $request->only(['id', 'status', 'company']));
        $companies = $this->companyBusiness->findByCondition(
            $conds,
            [],
            ['id', 'company', 'email', 'company_address', 'phone', 'status']
        )->get();
        $listStatus = $this->companyBusiness->getListStatus();

        return Excel::download(new CompanyExport($companies, $listStatus), 'companies.csv');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $listStatus = $this->companyBusiness->getListStatus();

        return view('admin.company.create', compact('listStatus'));
    }

    /**
     * show verification screen
     *
     * @param  \Illuminate\Http\CreateRequest  $request
     * @return view
     */
    public function verifyCreate(CreateRequest $request)
    {
        $data = $request->all();
        $listStatus = $this->companyBusiness->getListStatus();

        return view('admin.company.verify-create', compact('data', 'listStatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->companyBusiness->create($request->all());

        return redirect()->route('admin.company.index')->with([
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
        $company = $this->companyBusiness->findById($id);
        $listStatus = $this->companyBusiness->getListStatus();

        return view('admin.company.edit', compact('company', 'listStatus'));
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
        $listStatus = $this->companyBusiness->getListStatus();

        return view('admin.company.verify-update', compact('data', 'listStatus'));
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
        $this->companyBusiness->update($id, $request->all());

        return redirect()->route('admin.company.index')->with([
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
            if ($this->companyBusiness->delete($id)) {
                Session::put('deleted_success', true);

                // return response()->json('success', 200);
            } else {
                Session::put('deleted_failed', true);
                // return response()->json('failure', 400);
            }
            return redirect()->route('admin.company.index');
        } catch (\Exception $e) {
            Session::put('deleted_failed', true);
            \Log::error($e);
            throw $e;
        }
    }

    // Company application
    public function application(Request $request)
    {
        $dataCondition = [
            'limit' => COMPANY_PER_PAGE,
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);
        $datas = $this->companyBusiness->list($dataCondition);

        $listStatusApprove = $this->companyBusiness->getListStatusApprove();

        return view('admin.company.application', compact('datas', 'listStatusApprove'));
    }

    public function confirmApprove(Request $request, $id)
    {
        $data = $this->companyBusiness->findById($id);
        return view('admin.company.confirm-approve', compact('data'));
    }

    public function approve(Request $request, $id)
    {
        try {
            $data = $this->companyBusiness->findById($id);
            // Send Mail
            SendMailTemplate::dispatch(MAIL_TEMPLATES_APPROVE_THE_COMPANY, $data->email);
            // Update
            $data->update([
                'status' => ACTIVE,
                'status_approve' => COMPANY_APPROVED,
            ]);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->route('admin.company-application.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->route('admin.company-application.index');
        }
    }

    public function disapprove(Request $request, $id)
    {
        try {
            $data = $this->companyBusiness->findById($id);
            // Send Mail
            SendMailTemplate::dispatch(MAIL_TEMPLATES_DISAPPROVE_THE_COMPANY, $data->email);
            // Update
            $data->update([
                'status_approve' => COMPANY_DISAPPROVED,
            ]);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.success'), __('messages.CM001_L006'));
            return redirect()->route('admin.company-application.index');
        } catch (\Exception $e) {
            \Log::error($e);
            \FlashMessageHelper::setMessage(request(), config('options.messages.type.error'), __('messages.CM001_L009'));
            return redirect()->route('admin.company-application.index');
        }
    }
}
