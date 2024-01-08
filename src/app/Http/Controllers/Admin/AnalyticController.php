<?php

namespace App\Http\Controllers\Admin;

use App\Business\OrderBusiness;
use App\Helpers\CommonHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Company;
use App\Models\Gacha;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AnalyticExport;

class AnalyticController extends Controller
{
    protected $orderBusiness;

    public function __construct(
        OrderBusiness $orderBusiness,
    ) {
        $this->orderBusiness = $orderBusiness;
    }

    public function index(Request $request)
    {
        $startTime = $request->start_time ?? Carbon::now()->subMonth(11)->format('Y-m-01');
        $endTime = $request->end_time ?? Carbon::now()->format('Y-m-t');
        $type = $request->type ?? ANALYTIC_DEFAULT;
        $isShow = '';
        switch ($type) {
            case ANALYTIC_DEFAULT:
                $data = $this->getAnalyticDefault($startTime, $endTime);
                $isShow = $this->orderBusiness->isShowChart($data, $isShow);
            break;
            case ANALYTIC_CATEGORY:
                $data = $this->getAnalyticCategory($startTime, $endTime);
                $isShow = $this->orderBusiness->isShowChart($data, $isShow);
            break;
            case ANALYTIC_GACHA:
                $data = $this->getAnalyticGacha($startTime, $endTime);
            break;
            case ANALYTIC_COMPANY:
                $data = $this->getAnalyticCompany($startTime, $endTime);
            break;
        }
        
        return view('admin.analytics.index', compact(
            'startTime',
            'endTime',
            'type',
            'data',
            'isShow'
        ));
    }

    /**
     * Get Data and export CSV.
     */
    public function download(Request $request)
    {
        $startTime = $request->start_time ?? Carbon::now()->subMonth(11)->format('Y-m-01');
        $endTime = $request->end_time ?? Carbon::now()->format('Y-m-t');
        $type = $request->type ?? ANALYTIC_DEFAULT;
        $dataCSV = [];
        switch ($type) {
            case ANALYTIC_DEFAULT:
                $data = $this->getAnalyticDefault($startTime, $endTime);
                $dataCSV = [
                    'file_name' => __('labels.ANLT001_L002').'_'.time(),
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
            case ANALYTIC_CATEGORY:
                $data = $this->getAnalyticCategory($startTime, $endTime);
                $dataCSV = [
                    'file_name' => __('labels.ANLT001_L003').'_'.time(),
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
                $data = $this->getAnalyticGacha($startTime, $endTime);
                $dataCSV = [
                    'file_name' => __('labels.ANLT001_L004').'_'.time(),
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
            case ANALYTIC_COMPANY:
                $data = $this->getAnalyticCompany($startTime, $endTime);
                $dataCSV = [
                    'file_name' => __('labels.ANLT001_L005').'_'.time(),
                    'fields' => [
                        $startTime.' ~ '.$endTime
                    ],
                    'data' => [],
                    'header' => ['ID', __('labels.ANLT001_L017') , __('labels.ANLT001_L018')],
                ];
                foreach ($data as $item) {
                    $dataCSV['data'][] = [
                        $item->id,
                        $item->company,
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
    public function getAnalyticDefault($startTime, $endTime)
    {
        $data = [];
        // Data Order
        $orders = Order::whereDate('created_at', '>=', $startTime)
                        ->whereDate('created_at', '<=', $endTime)
                        ->where('status_deliver', '!=', DELEVERY_CANCELED)
                        ->get();

        $period =  Carbon::create($startTime)->monthsUntil(Carbon::create($endTime));
        foreach ($period as $date) {
            // List Month
            $data['categories'][] = $date->year.'年'.$date->shortMonthName;
            // List Price
            $startMonth = $date->format('Y-m-01 00:00:00');
            $endMonth = $date->format('Y-m-t 23:59:59');
            $orderOfMonth = $orders->where('created_at', '>=', $startMonth)->where('created_at', '<=', $endMonth);
            $totalPrice = 0;
            foreach($orderOfMonth as $order) {
                $totalPrice += $order->getAmount();
            }
            $data['data'][] = $totalPrice/10000;
        }
        return $data;
    }

    /**
     * Analytic with category
     *
     * @return array
     */
    public function getAnalyticCategory($startTime, $endTime)
    {
        $data = [];
        // Data Order
        $orders = Order::with('gacha', 'gacha.category')
                        ->whereDate('created_at', '>=', Carbon::createFromFormat('Y-m-d', $startTime)->startOfDay())
                        ->whereDate('created_at', '<=', Carbon::createFromFormat('Y-m-d', $endTime)->endOfDay())
                        ->where('status_deliver', '!=', DELEVERY_CANCELED)
                        ->get();
        $orders = $orders->map(function ($row) {
            $gacha = $row->gacha;
            $category = $gacha ? $gacha->category : '';
            $categoryId = $category ? $category->id : '';
            $row->category_id = $categoryId;

            return $row;
        });
        // Data Category
        $categories = Category::get();
        foreach ($categories as $category) {
            // List Category
            $data['categories'][] = $category->name;
            // List Price
            $orderOfCategory = $orders->where('category_id', $category->id);
            $totalPrice = 0;
            foreach($orderOfCategory as $order) {
                $totalPrice += $order->getAmount();
            }
            $data['data'][] = $totalPrice/10000;
        }
        return $data;
    }

    /**
     * Analytic with gacha
     *
     * @return array
     */
    public function getAnalyticGacha($startTime, $endTime)
    {
        $startTime = Carbon::createFromFormat('Y-m-d', $startTime)->startOfDay();
        $endTime = Carbon::createFromFormat('Y-m-d', $endTime)->endOfDay();

        $gacha = Gacha::query()
                        ->join('orders', 'orders.gacha_id', 'gachas.id')
                        ->whereDate('orders.created_at', '>=', $startTime)
                        ->whereDate('orders.created_at', '<=', $endTime)
                        ->where('orders.status_deliver', '!=', DELEVERY_CANCELED)
                        ->select('gachas.*')
                        ->groupBy('gachas.id')
                        ->with([
                            'orders' => function($query) use($startTime, $endTime) {
                                $query->whereDate('created_at', '>=', $startTime)
                                    ->whereDate('created_at', '<=', $endTime);
                            }
                        ])
                        ->get();
        $gacha = $gacha->map(function ($row) {
            $orderAmount = 0;
            foreach ($row->orders as $order) {
                $orderAmount += $order->getAmount();
            }
            $row->order_amount = $orderAmount;
            return $row;
        });
        $data = $gacha->sortByDesc('order_amount')->take(ANALYTIC_GACHA_PER_PAGE);
        return $data;
    }

    /**
     * Analytic with category
     *
     * @return array
     */
    public function getAnalyticCompany($startTime, $endTime)
    {
        $startTime = Carbon::createFromFormat('Y-m-d', $startTime)->startOfDay();
        $endTime = Carbon::createFromFormat('Y-m-d', $endTime)->endOfDay();

        $company = Company::query()
                            ->join('gachas', 'gachas.company_id', 'companies.id')
                            ->join('orders', 'orders.gacha_id', 'gachas.id')
                            ->whereDate('orders.created_at', '>=', $startTime)
                            ->whereDate('orders.created_at', '<=', $endTime)
                            ->where('orders.status_deliver', '!=', DELEVERY_CANCELED)
                            ->select('companies.*')
                            ->groupBy('companies.id')
                            ->with([
                                'gachas',
                                'gachas.orders' => function($query) use($startTime, $endTime) {
                                    $query->whereDate('created_at', '>=', $startTime)
                                        ->whereDate('created_at', '<=', $endTime);
                                }
                            ])
                            ->get();
        $company = $company->map(function ($row) {
            $orderAmount = 0;
            foreach ($row->gachas as $gacha) {
                foreach($gacha->orders as $order) {
                    $orderAmount += $order->getAmount();
                }
            }
            $row->order_amount = $orderAmount;
            return $row;
        });
        $data = $company->sortByDesc('order_amount')->take(ANALYTIC_COMPANY_PER_PAGE);
        return $data;
    }

    /**
     * Analytic Detail
     *
     * @return array
     */
    public function getAnalyticDetail($staticMonth)
    {
        $startMonth = $staticMonth->format('Y-m-01 00:00:00');
        $endMonth = $staticMonth->format('Y-m-t 23:59:59');
        $companyOfMonth = Company::query()
            ->join('gachas', 'gachas.company_id', 'companies.id')
            ->join('orders', 'orders.gacha_id', 'gachas.id')
            ->whereDate('orders.created_at', '>=', $startMonth)
            ->whereDate('orders.created_at', '<=', $endMonth)
            ->select('companies.*')
            ->groupBy('companies.id')
            ->with([
                'gachas',
                'gachas.orders' => function($query) use($startMonth, $endMonth) {
                    $query->whereDate('created_at', '>=', $startMonth)
                        ->whereDate('created_at', '<=', $endMonth);
                }
            ])
            ->orderBy('companies.company', 'DESC')
            ->get();

        $companyOfMonth = $companyOfMonth->map(function ($company) {
            $orderAmount = 0;
            $totalCommission = 0;
            foreach ($company->gachas as $gacha) {
                foreach($gacha->orders as $order) {
                    $orderAmount += $order->getAmount();
                    $totalCommission += $order->gacha_price * $order->quantity * ($company->commission / 100);
                }
            }
            $company->order_amount = $orderAmount - $totalCommission;

            return $company;
        });

        return $companyOfMonth;
    }

    /**
     * Show analytics detail
     *
     * @return view
     */
    public function detail(Request $request)
    {
        $staticMonth = $request->static_month ?? Carbon::now()->startOfMonth()->format('Y-m');
        $data = $this->getAnalyticDetail(Carbon::parse($staticMonth))
            ->paginateCollection(ANALYTIC_DETAIL_PER_PAGE);
        $params = $request->all();

        return view('admin.analytics.detail', compact('staticMonth', 'data', 'params'));
    }

    /**
     * Export CSV list analytic by conditions.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFile(Request $request)
    {
        $analytics = $this->getAnalyticDetail(Carbon::parse($request->static_month));

        return Excel::download(new AnalyticExport($analytics), 'analytics.csv');
    }
}
