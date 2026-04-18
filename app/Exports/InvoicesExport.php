<?php

namespace App\Exports;

use App\Models\Invoice;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

//class InvoicesExport implements FromCollection
class InvoicesExport implements FromArray, WithHeadings
{
    protected $invoices;

    public function __construct(array $invoices){
        $this->invoices = $invoices;
    }

    public function array():array
    {
        return $this->invoices;
    }

    public function headings(): array{
        return
        [
            'Created At',
            'Owner Entity',
            'Title',
            'Client Entity',
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
        return Invoice::all();
    }
    */
}
