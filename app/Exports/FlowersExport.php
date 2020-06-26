<?php

namespace App\Exports;

use App\Models\Flower;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class FlowersExport implements FromCollection, Responsable, WithHeadings, ShouldAutoSize
{
    use Exportable;

    /**
     * Optional headers
     */
    private $headers = [
        'Content-Type' => 'text/csv; charset=UTF-8',
        'Content-Encoding' => 'UTF-8'

    ];
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Flower::all();
    }

    public function headings(): array
    {
        return [
            'Id',
            'Catalog Id',
            'Name',
            'Color',
            'Price',
            'Discount',
            'Avatar',
            'Images',
            'View',
            'Created at',
            'Updated at',
        ];
    }
}
