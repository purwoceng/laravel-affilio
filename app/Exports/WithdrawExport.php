<?php

namespace App\Exports;

use App\Models\Withdraw;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class WithdrawExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $view;
    public $startDate;
    public $endDate;
    public $fundCode;
    public function __construct($status = '', $dateRange = [])
    {
        $this->fundCode = $status;

        if (isset($dateRange[0])) $this->startDate = $dateRange[0];

        if (isset($dateRange[1])) $this->endDate = $dateRange[1];
    }

    public function view(): View
    {
        $query = Withdraw::whereNotNull('id');

        if ($this->fundCode != 'all') {
            $query = $query->where('code', $this->fundCode);
        }

        if ($this->fundCode == 'all') {
            $query = $query->where(function ($query) {
                $query->where('code', '=', 'PDB')
                    ->orWhere('code', '=', 'PDK');
            });
        }

        if ($this->startDate && $this->endDate) {
            $query->whereDate('created_at', '>=',  [$this->startDate])->whereDate('created_at', '<=', [$this->endDate]);
        }



        $withdraws = $query->get();

        return view('dana.withdraw.exportexcel', [
            'withdraws' => $withdraws,
        ]);
    }

    public function registerEvents(): array
    {

        return [
            AfterSheet::class    => function (AfterSheet $event) {
                $alphabet       = $event->sheet->getHighestDataColumn();
                $totalRow       = $event->sheet->getHighestDataRow();
                $cellRange      = 'A1:' . $alphabet . $totalRow;
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
