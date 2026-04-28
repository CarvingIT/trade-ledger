<?php

namespace App\Exports;

use App\Models\Purchase;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PurchasesExport implements FromArray, WithHeadings
{
    protected $purchases;

    public function __construct(array $purchases){
        $this->purchases = $purchases;
    }

    public function array():array
    {
        return $this->purchases;
    }

    public function headings(): array{
        return
        [
            'Created At',
            'Owner Entity',
            'Title',
            'Vendor Entity',
            'Total Amount',
            'Total Amount Including Tax',
            'Tax Type',
            'Tax Value',
            'Description'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    /*
    public function collection()
    {
        return Purchase::all();
    }
    */
}
