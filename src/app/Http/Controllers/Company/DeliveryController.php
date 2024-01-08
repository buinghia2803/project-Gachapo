<?php

namespace App\Http\Controllers\Company;

use App\Business\DeliveryBusiness;
use App\Exports\DeliveryExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Delivery\DetailDeliveryRequest;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected DeliveryBusiness $deliveryBusiness;

    public function __construct(DeliveryBusiness $deliveryBusiness)
    {
        $this->deliveryBusiness = $deliveryBusiness;
    }

    public function index(Request $request)
    {
        $dataCondition = [
            'limit' => DELIVERY_PER_PAGE,
            'company_id' => Auth::guard(ROLE_COMPANY)->user()->id,
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);

        $deliveries = $this->deliveryBusiness->list($dataCondition, ['orderDetails.product', 'user','gacha','gacha.company'], ['*'], []);
        $params = $request->all();
        $statusList = $this->deliveryBusiness->getStatusDeliveryList();

        if ($deliveries->currentPage() > $lastPage = $deliveries->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return view('company.delivery.index', compact('params'));
        }
        if($request->start_date > $request->end_date){
            return redirect()->back()->with([
                'error' => __('messages.ANM001_MSG001'),
            ]);
        }
        return view('company.delivery.index', compact('deliveries', 'params', 'statusList'));
    }

     /**
     * Export list delivery by conditions.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFile(Request $request)
    {
        $deliveries = $this->deliveryBusiness->findByCondition(
            $request->only(['id', 'user_name', 'start_date', 'end_date']),
            ['orderDetails.product', 'user']
        )->get();

        $statusList = $this->deliveryBusiness->getStatusDeliveryList();
        $date = '発送伝票管理' . date('Ymd');

        return Excel::download(new DeliveryExport($deliveries, $statusList),  $date . '.csv');
    }

    /**
     * Export pdf of order
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return pdf file
     */
    public function exportPdf($id)
    {
        $infor = $this->getData($id);
        $data = $infor['data'];
        $delivery = $infor['delivery'];
        $statusList = $infor['statusList'];
        $pdf = PDF::loadView('company.delivery.detail_pdf', compact('data', 'delivery', 'statusList'))->setPaper('A4');
        $fileName = '購入' . $id .  'の発送伝票情報' . Carbon::now()->year . Carbon::now()->format('m') . Carbon::now()->format('d');

        return $pdf->download($fileName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $infor = $this->getData($id);
        $data = $infor['data'];
        $delivery = $infor['delivery'];
        $statusList = $infor['statusList'];

        return view('company.delivery.detail', compact('data', 'delivery', 'statusList'));
    }

    /**
     * Get data detail of order
     */
    public function getData($id)
    {
        $delivery  = $this->deliveryBusiness->getInformationDetail($id);
        $statusList = $this->deliveryBusiness->getStatusDeliveryList();
        $data = [];
        $data['order_id'] = $id;
        $order = count($delivery) ? $delivery->first()->order : '';
        if ($order) {
            $data['status_deliver'] = $order->status_deliver;
            $data['created_at'] = $order->created_at;
            $data['address_delivery'] = $order->address_delivery;
            $data['date_of_shipment'] = $order->date_of_shipment;
            $data['user'] = $order->user;
        }

        return [
            'delivery' => $delivery,
            'statusList' => $statusList,
            'data' => $data,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(DetailDeliveryRequest $request, $id)
    {
        $this->deliveryBusiness->update($id, $request->only('status_deliver'));

        return redirect()->route('company.delivery.index')->with([
            'success' => __('messages.CM001_L006'),
        ]);
    }
}
