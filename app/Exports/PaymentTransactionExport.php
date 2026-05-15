<?php

namespace App\Exports;

use App\Models\Transaction;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PaymentTransactionExport implements FromArray, WithHeadings
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
            'Invoice ID',
            'Client Entity',
            'Owner Entity',
            'Total Amount',
            'Account Name',
            'Status'
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
