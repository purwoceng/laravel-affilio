<?php

namespace App\Exports;

use App\Models\Fund;
use App\Exports\FundTransactionExport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FundMultiSheet implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    public $startDate;
    public $endDate;
    public $fundCode;
    public function __construct($status = '', $dateRange = [])
    {
        $this->fundCode = $status;

        if (isset($dateRange[0])) $this->startDate = $dateRange[0];

        if (isset($dateRange[1])) $this->endDate = $dateRange[1];
    }

    public function sheets(): array
    {
        $sheets = [];

        for ($fund = 1; $fund <= 12; $fund++) {
            $sheets[] = new FundTransactionExport($this->fundcode, $fund);
        }

        return $sheets;
    }

}
