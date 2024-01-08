<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    protected $users;
    protected $listStatus;

    public function __construct($users, $listStatus)
    {
        $this->users = $users;
        $this->listStatus = $listStatus;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = [];
        foreach ($this->users as $value) {
            $data[] = [
                '0' => $value->id,
                '1' => $value->name,
                '2' => $value->email,
                '3' => $value->address_first,
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
            'ID',
            __('labels.ADM001_L002'),
            __('labels.CM001_L030'),
            __('labels.CM001_L021'),
            __('labels.CM001_L031'),
        ];
    }
}
