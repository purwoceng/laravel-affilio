<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class OrderExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public $view;
    public $startDate;
    public $endDate;
    public $orderStatus;

    public function __construct($status = '', $dateRange = [])
    {
        $this->orderStatus = $status;

        if (isset($dateRange[0])) $this->startDate = $dateRange[0];

        if (isset($dateRange[1])) $this->endDate = $dateRange[1];
    }

    public function view():View
    {
        $query = Order::whereNotNull('id');

        if ($this->orderStatus != 'all') {
            $query = $query->where('status', $this->orderStatus);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereDate('date_created', '>=',  [$this->startDate])->whereDate('date_created', '<=', [$this->endDate]);
        }

        $orders = $query->get();

        return view('orders.exportexcel', [
            'orders' => $orders,
        ]);
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function(AfterSheet $event){
                $alphabet       = $event->sheet->getHighestDataColumn();
                $totalRow       = $event->sheet->getHighestDataRow();
                $cellRange      = 'A1:'.$alphabet.$totalRow;
                $event->sheet->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
         ]);
            },
        ];
    }
}
