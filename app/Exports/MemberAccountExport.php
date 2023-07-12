<?php

namespace App\Exports;

use App\Models\Member;
use App\Models\MemberAccount;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class MemberAccountExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $view;
    // public $startDate;
    // public $endDate;
    public $bank;
    // public $city_name;

    public function __construct($bank = '', $dateRange = [])
    {
        $this->bank = $bank;
    }

    public function view(): View
    {
        $query = MemberAccount::with('members')->whereNotNull('id');

        if ($this->bank!= 'all') {
            $query = $query->where('bank_name', $this->bank);
        }

        $membersaccounts = $query->paginate(500);

        return view('members.account.exportexcel', [
            'membersaccounts' => $membersaccounts,
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
