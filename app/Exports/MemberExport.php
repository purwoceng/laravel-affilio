<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;

class MemberExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public $view;
    public $startDate;
    public $endDate;
    public $member_type_id;

    public function __construct($member_type_id = '', $dateRange = [])
    {
        $this->member_type_id = $member_type_id;

        if (isset($dateRange[0])) $this->startDate = $dateRange[0];

        if (isset($dateRange[1])) $this->endDate = $dateRange[1];
    }

    public function view(): View
    {
        $query = Member::whereNotNull('id');

        if ($this->member_type_id != 'all') {
            $query = $query->where('member_type_id', $this->member_type_id);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereDate('date_created', '>=',  [$this->startDate])->whereDate('date_created', '<=', [$this->endDate]);
        }

        $members = $query->get();

        return view('members.exportexcel', [
            'members' => $members,
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
