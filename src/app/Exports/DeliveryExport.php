<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class DeliveryExport implements FromCollection, WithHeadings
{
    protected $deliveries;
    protected $statusList;

    public function __construct($deliveries, $statusList)
    {
        $this->deliveries = $deliveries;
        $this->statusList = $statusList;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        foreach ($this->deliveries as $delivery) {
            $data[] = [
                '0' => $delivery->id,
                '1' => $delivery->user ? $delivery->user->name : '',
                '2' => $this->showProductName($delivery->orderDetails),
                '3' => Carbon::parse($delivery->created_at)->format('Y/m/d'),
                '4' => Carbon::parse($delivery->date_of_shipment)->format('Y/m/d'),
                '5' => $this->statusList[$delivery->status_deliver]
            ];
        }

        return collect($data);
    }

    /**
    * @return array heading title
    */
    public function headings(): array
    {
        return [
            __('labels.ADEL001_L002'),
            __('labels.CM001_L038'),
            __('labels.GAC001_L016'),
            __('labels.ADEL001_L004'),
            __('labels.ADEL001_L005'),
            __('labels.ADEL001_L003')
        ];
    }

    /*
    * @return string include name of product
    */
    public function showProductName($orderDetails)
    {
        $productNames = "";
        $quantityOrder = count($orderDetails);
        if ($quantityOrder) {
            for($i = 0; $i <= ($quantityOrder - 2); $i++) {
                $productNames .= $orderDetails[$i]->product->name . ",";
            }
            $productNames .=  $orderDetails[$quantityOrder - 1]->product->name . "";
        }

        return $productNames;
    }
}
