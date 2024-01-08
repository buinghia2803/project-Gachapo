<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompanyExport implements FromCollection, WithHeadings
{
    protected $companies;
    protected $listStatus;

    public function __construct($companies, $listStatus)
    {
        $this->companies = $companies;
        $this->listStatus = $listStatus;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        foreach ($this->companies as $value) {
            $data[] = [
                '0' => $value->id,
                '1' => $value->company,
                '2' => $value->email,
                '3' => $value->company_address,
                '4' => $value->phone,
                '5' => $this->listStatus[$value->status]
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
            __('labels.COC001_L010'),
            __('labels.COC001_L003'),
            __('labels.COC001_L007'),
            __('labels.CM001_L021'),
            __('labels.CM001_L025'),
            __('labels.NML001_L007')
        ];
    }
}
