<?php


namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderRepository extends BaseRepository
{

    /**
     * Get searchable fields array
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        // TODO: Implement getFieldsSearchable() method.
    }

    /**
     * Configure the Model
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    /**
     * Search by column
     *
     * @return query builder
     */
    public function search($query, $column, $data)
    {
        switch ($column) {
            case 'id':
                return $query->where('orders.id', $data);
                break;
            case 'status_deliver':
                return $query->where($column, $data);
                break;
            case 'company_name':
                return $query->whereHas('gacha', function ($q) use ($data) {
                    $q->whereHas('company', function ($query) use ($data) {
                        $query->where('company', 'like', '%' . $data . '%');
                    });
                });
                break;
            case 'user_name':
                return $query->whereHas('user', function ($q) use ($data) {
                    $q->where('name', 'like', '%' . $data . '%');
                });
                break;
            case 'start_date':
                return $query->where('orders.created_at', '>=', Carbon::createFromFormat('Y-m-d', $data)->startOfDay());
                break;
            case 'end_date':
                return $query->where('orders.created_at', '<=', Carbon::createFromFormat('Y-m-d', $data)->endOfDay());
                break;
            case 'company_id':
                return $query->join('gachas', 'gachas.id', 'orders.gacha_id')
                ->join('users', 'users.id', 'orders.user_id')
                ->join('companies', 'companies.id', 'gachas.company_id')
                ->select('orders.*','gachas.company_id','gachas.name as gacha_name','users.name as user_name')
                ->where('companies.id', $data)
                ->groupBy('orders.id');
                break;
            default:
                return $query;
                break;
        }
    }

    /*
    * get status delivery of order
    */
    public function getStatusDeliveryList()
    {
        return [
            NOT_DELIVERY => __('labels.ADEL001_S001'),
            IN_DELIVERY => __('labels.ADEL001_S002'),
            DELIVERED => __('labels.ADEL001_S003'),
            DELEVERY_CANCELED => __('labels.CM001_L013'),
        ];
    }

    /*
    * Get detail information of order
    */
    public function getInformationDetail($id)
    {
        $order = OrderDetail::query()
            ->where('order_id', $id)
            ->select('order_details.product_id' ,'order_details.order_id', \DB::raw('count(order_details.product_id) as totalProduct'))
            ->groupBy('order_details.product_id', 'order_id')
            ->with([
                'product',
                'order.user'
            ])
            ->get();

        return $order;
    }

    /*
    * Get order id by gachaID
    */
    public function getOrderIdsByGacha($gachaIds)
    {
        return Order::whereIn('gacha_id', $gachaIds)->pluck('id')->all();
    }

    /**
     * Get order by time
     */
    public function getOrderByTime($gachaIds, $startTime, $endTime)
    {
        return Order::whereDate('created_at', '>=', $startTime)
            ->whereDate('created_at', '<=', $endTime)
            ->whereIn('gacha_id', $gachaIds)
            ->get();
    }
}
