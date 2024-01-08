<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Business\DeliveryBusiness;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DeliveryExport;
use PDF;
use Carbon\Carbon;

class DeliveryController extends Controller
{
    protected DeliveryBusiness $deliveryBusiness;

    public function __construct(DeliveryBusiness $deliveryBusiness)
    {
        $this->deliveryBusiness = $deliveryBusiness;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataCondition = [
            'limit' => DELIVERY_PER_PAGE,
        ];
        $dataCondition = array_merge($request->all(), $dataCondition);

        $deliveries = $this->deliveryBusiness->list($dataCondition, ['orderDetails.product', 'user'], ['*'], []);
        $params = $request->all();
        $statusList = $this->deliveryBusiness->getStatusDeliveryList();

        if ($deliveries->currentPage() > $lastPage = $deliveries->lastPage()) {
            if (array_key_exists('page', $params)) {
                $params['page'] = $lastPage;
            }

            return view('admin.delivery.index', compact('params', 'statusList'));
        }

        return view('admin.delivery.index', compact('deliveries', 'params', 'statusList'));
    }

    /**
     * Export list delivery by conditions.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportFile(Request $request)
    {
        
        $deliveries = $this->deliveryBusiness->findByCondition(
            $request->only(['company_name', 'user_name', 'status_deliver', 'start_date', 'end_date']),
            ['orderDetails.product', 'user']
        )->get();

        $statusList = $this->deliveryBusiness->getStatusDeliveryList();

        return Excel::download(new DeliveryExport($deliveries, $statusList), 'deliveries.csv');
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
        $infor = $this->getData($id);
        $data = $infor['data'];
        $delivery = $infor['delivery'];
        $statusList = $infor['statusList'];

        return view('admin.delivery.detail', compact('data', 'delivery', 'statusList'));
    }

    /**
     * Export pdf of order
     *
     * @return pdf file
     */
    public function exportPdf($id)
    {
        $infor = $this->getData($id);
        $data = $infor['data'];
        $delivery = $infor['delivery'];
        $statusList = $infor['statusList'];
        $pdf = PDF::loadView('admin.delivery.detail_pdf', compact('data', 'delivery', 'statusList'))->setPaper('A4');
        $fileName = '購入' . $id .  'の発送伝票情報' . Carbon::now()->year . Carbon::now()->format('m') . Carbon::now()->format('d');

        return $pdf->download($fileName);
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
        $this->deliveryBusiness->update($id, $request->only('status_deliver'));

        return redirect()->route('admin.delivery.index')->with([
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
        //
    }
}
