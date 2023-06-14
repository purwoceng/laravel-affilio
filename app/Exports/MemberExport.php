<?php

namespace App\Exports;

use App\Models\Member;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;


class MemberExport implements FromView, WithEvents, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public $view;
    // public $startDate;
    // public $endDate;
    public $memberType;
    public function __construct($status = '', $dateRange = [])
    {
        $this->memberType = $status;

        // if (isset($dateRange[0])) $this->startDate = $dateRange[0];

        // if (isset($dateRange[1])) $this->endDate = $dateRange[1];
    }

    public function view(): View
    {
        $query = Member::whereNotNull('id');

        if ($this->memberType != 'all') {
            $query = $query->where('member_type_id', $this->memberType);
        }

        // if ($this->memberType == 'all') {
        //     $query = $query->where(function ($query) {
        //         $query->where('member_type_id', '=', '0')
        //             ->orWhere('member_type_id', '=', '1')
        //             ->orWhere('member_type_id', '=', '2')
        //             ->orWhere('member_type_id', '=', '3');
        //     });
        // }

        // if ($this->startDate && $this->endDate) {
        //     $query->whereDate('created_at', '>=',  [$this->startDate])->whereDate('created_at', '<=', [$this->endDate]);
        // }



        $members = $query->paginate(500);

        return view('members.member.exportexcel', [
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
