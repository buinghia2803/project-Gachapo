<?php

namespace App\Business;

use App\Repositories\OrderRepository;
use App\Repositories\GachaRepository;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DeliveryBusiness extends BaseBusiness
{
    protected OrderRepository $orderRepository;
    protected GachaRepository $gachaRepository;

    public function __construct(OrderRepository $orderRepository, GachaRepository $gachaRepository)
    {
        parent::__construct($orderRepository);
        $this->orderRepository = $orderRepository;
        $this->gachaRepository = $gachaRepository;
    }

    /*
    * get deliverey status of order
    */
    public function getStatusDeliveryList()
    {
        return $this->orderRepository->getStatusDeliveryList();
    }

    /*
    * get detail information of order
    */
    public function getInformationDetail($id)
    {
        return $this->orderRepository->getInformationDetail($id);
    }

    /*
    * get detail information for pdf download
    */
    public function getInformationForPDF($id)
    {
        return $this->orderRepository->getInformationForPDF($id);
    }

    /*
    * Get order id by gachaID
    */
    public function getOrderIdsByGacha($gachaIds)
    {
        return $this->orderRepository->getOrderIdsByGacha($gachaIds);
    }

    /**
     * Get current revenue
     */
    public function getCurrentMonthRevuenue($gachaIds, $commission)
    {
        $startMonth = Carbon::now()->startOfMonth();
        $endMonth = Carbon::now()->endOfMonth();
        $orders = $this->getOrderByTime($gachaIds, $startMonth, $endMonth);
        $totalPrice = 0;
        $totalGacha = 0;
        $totalCommission = 0;
        foreach ($orders as $order) {
            $totalPrice += $order->getAmount();
            $totalGacha += $order->quantity;
            $totalCommission += $order->gacha_price * $order->quantity * ($commission / 100);
        }

        $actualRevenue = $totalPrice - $totalCommission;

        return [
            'totalPrice' => $totalPrice,
            'totalGacha' => $totalGacha,
            'actualRevenue' => $actualRevenue,
        ];
    }

    /**
     * Get order by time
     */
    public function getOrderByTime($gachaIds, $startTime, $endTime)
    {
        return $this->orderRepository->getOrderByTime($gachaIds, $startTime, $endTime);
    }

    /**
     * Default Analytic
     *
     * @return array
     */
    public function getAnalyticDefault($startTime, $endTime, $gachaIds)
    {
        $startTime = Carbon::createFromFormat('Y-m-d', $startTime)->startOfDay();
        $endTime = Carbon::createFromFormat('Y-m-d', $endTime)->endOfDay();
        $data = [];
        // Data Order
        $orders = $this->getOrderByTime($gachaIds, $startTime, $endTime);
        $period =  Carbon::create($startTime)->monthsUntil(Carbon::create($endTime));
        foreach ($period as $date) {
            // List Month
            $data['categories'][] = $date->year . '年' . $date->shortMonthName;
            // List Price
            $startMonth = $date->format('Y-m-01 00:00:00');
            $endMonth = $date->format('Y-m-t 23:59:59');
            $orderOfMonth = $orders->where('created_at', '>=', $startMonth)
                ->where('created_at', '<=', $endMonth);
            $totalPrice = 0;
            foreach ($orderOfMonth as $order) {
                $totalPrice += $order->getAmount();
            }
            $data['data'][] = $totalPrice / 10000;
        }

        return $data;
    }

    /**
     * Analytic with gacha
     *
     * @return array
     */
    public function getAnalyticGacha($startTime, $endTime, $gachaIds)
    {
        $startTime = Carbon::createFromFormat('Y-m-d', $startTime)->startOfDay();
        $endTime = Carbon::createFromFormat('Y-m-d', $endTime)->endOfDay();
        $gacha = $this->gachaRepository->getGachaByIds($gachaIds, $startTime, $endTime);
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
}
