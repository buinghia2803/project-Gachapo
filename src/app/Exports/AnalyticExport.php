<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AnalyticExport implements FromCollection, WithHeadings
{
    protected $analytics;

    public function __construct($analytics)
    {
        $this->analytics = $analytics;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        foreach ($this->analytics as $key => $value) {
            $data[] = [
                '0' => $key + 1,
                '1' => $value->company,
                '2' => \CommonHelper::formatPrice($value->order_amount),
                '3' => $value->bank_name,
                '4' => $value->branch_name,
                '5' => $value->bank_number,
                '6' => $value->commission,
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
            __('ID'),
            __('labels.ANLT001_L012'),
            __('labels.ANLT001_L013'),
            __('labels.ANLT001_L014'),
            __('labels.ANLT001_L015'),
            __('labels.ANLT001_L016'),
            __('labels.COC001_L008'),
        ];
    }
}
