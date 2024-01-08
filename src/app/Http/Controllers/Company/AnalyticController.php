<?php

namespace App\Http\Controllers\Company;

use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Gacha;
use App\Models\Review;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalyticExport;
use App\Business\DeliveryBusiness;
use App\Business\CompanyBusiness;
use App\Business\ReviewBusiness;
use Illuminate\Support\Facades\Auth;

class AnalyticController extends Controller
{
    protected DeliveryBusiness $deliveryBusiness;
    protected CompanyBusiness $companyBusiness;
    protected ReviewBusiness $reviewBusiness;

    public function __construct(DeliveryBusiness $deliveryBusiness,
        CompanyBusiness $companyBusiness,
        ReviewBusiness $reviewBusiness)
    {
        $this->deliveryBusiness = $deliveryBusiness;
        $this->companyBusiness = $companyBusiness;
        $this->reviewBusiness = $reviewBusiness;
    }

    /**
     * Display a listing of the static revunue
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $startTime = $request->start_time ?? Carbon::now()->subMonth(11)->format('Y-m-01');
        $endTime = $request->end_time ?? Carbon::now()->format('Y-m-t');
        $type = $request->type ?? ANALYTIC_DEFAULT;
        $gachaIds = $this->companyBusiness->getGachaIdsByCompany();
        switch ($type) {
            case ANALYTIC_DEFAULT:
                $data = $this->getAnalyticDefault($startTime, $endTime, $gachaIds);
            break;
            case ANALYTIC_GACHA:
                $data = $this->getAnalyticGacha($startTime, $endTime, $gachaIds);
            break;
        }
        $currentRevenue = $this->getCurrentMonthRevuenue($gachaIds, Auth::guard('company')->user()->commission);
        $orderIds = $this->deliveryBusiness->getOrderIdsByGacha($gachaIds);
        $newestReview = $this->getNewestReview($orderIds);

        return view('company.analytics.index', compact(
            'startTime',
            'endTime',
            'type',
            'data',
            'currentRevenue',
            'newestReview'
        ));
    }

    /**
     * Get current revenue
     */
    public function getCurrentMonthRevuenue($gachaIds, $commission)
    {
        $data = $this->deliveryBusiness->getCurrentMonthRevuenue($gachaIds, $commission);

        return [
            'totalPrice' => $data['totalPrice'],
            'totalGacha' => $data['totalGacha'],
            'actualRevenue' => $data['actualRevenue'],
        ];
    }

    /**
     * Get newest review
     */
    public function getNewestReview($orderIds)
    {

        return $this->reviewBusiness->getReviewByOrder($orderIds);
    }

    /**
     * Get Data and export CSV.
     */
    public function exportCsv(Request $request)
    {
        $fileName = __('labels.CDB001_L003') . Carbon::now()->year . Carbon::now()->format('m') . Carbon::now()->format('d');
        $startTime = $request->start_time ?? Carbon::now()->subMonth(11)->format('Y-m-01');
        $endTime = $request->end_time ?? Carbon::now()->format('Y-m-t');
        $type = $request->type ?? ANALYTIC_DEFAULT;
        $gachaIds = $this->companyBusiness->getGachaIdsByCompany();
        $dataCSV = [];
        switch ($type) {
            case ANALYTIC_DEFAULT:
                $data = $this->getAnalyticDefault($startTime, $endTime, $gachaIds);
                $dataCSV = [
                    'file_name' => $fileName,
                    'fields' => [
                        $startTime.' ~ '.$endTime
                    ],
                    'data' => []
                ];
                if (!empty($data['categories'])) {
                    $dataCSV['header'] = ['ID', __('labels.ANLT001_L017') , __('labels.ANLT001_L018')];
                    for ($i = 0; $i < count($data['categories']); $i++) {
                        $dataCSV['data'][] = [
                            ($i + 1),
                            $data['categories'][$i],
                            $data['data'][$i],
                        ];
                    }
                }
                break;
            case ANALYTIC_GACHA:
                $data = $this->getAnalyticGacha($startTime, $endTime, $gachaIds);
                $dataCSV = [
                    'file_name' => $fileName,
                    'fields' => [
                        $startTime.' ~ '.$endTime
                    ],
                    'data' => [],
                    'header' => ['ID', __('labels.ANLT001_L017') , __('labels.ANLT001_L018')],
                ];
                foreach ($data as $item) {
                    $dataCSV['data'][] = [
                        $item->id,
                        $item->getName(),
                        $item->order_amount,
                    ];
                }
            break;
        }
        return CommonHelper::ExportCsv($dataCSV);
    }

    /**
     * Default Analytic
     *
     * @return array
     */
    public function getAnalyticDefault($startTime, $endTime, $gachaIds)
    {
        return $this->deliveryBusiness->getAnalyticDefault($startTime, $endTime, $gachaIds);
    }

    /**
     * Analytic with gacha
     *
     * @return array
     */
    public function getAnalyticGacha($startTime, $endTime, $gachaIds)
    {
        return $this->deliveryBusiness->getAnalyticGacha($startTime, $endTime, $gachaIds);
    }
}
