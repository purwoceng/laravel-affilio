<?php

namespace App\Http\Controllers\Dana;

use App\Http\Controllers\Controller;
use App\Models\Fund;
use Illuminate\Http\Request;

class PensiunDashboardController extends Controller
{
    public function getDashboard(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $PensiunBronze = Fund::where('code', 'BPSB');
        $PensiunGold = Fund::where('code', 'BPSG');
        $PensiunPlatinum = Fund::where('code', 'BPSP');
        $PensiunDiamond = Fund::where('code', 'BPSD');

        if (!empty($startDate) && !empty($endDate)) {
            $PensiunBronze->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $PensiunGold->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $PensiunPlatinum->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $PensiunDiamond->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        } else {
            return response()->json([
                'status' => false,
                'errors' => [
                    'title' => 'Date Not Found',
                    'massages' => 'Not any date range selected',
                    'icon' => 'error',
                ],
            ]);
        }

        //Bonus Pensiun Bronze
        $countTotalPensiunBronze = $PensiunBronze->sum('value');
        //Bonus Pensiun Gold
        $countTotalPensiunGold = $PensiunGold->sum('value');
        //Bonus Pensiun Platinum
        $countTotalPensiunPlatinum = $PensiunPlatinum->sum('value');
        //Bonus Pensiun Diamond
        $countTotalPensiunDiamond = $PensiunDiamond->sum('value');

        $results = [
            'total_pensiun_bronze' => formatRupiah($countTotalPensiunBronze),
            'total_pensiun_gold' => formatRupiah($countTotalPensiunGold),
            'total_pensiun_platinum' => formatRupiah($countTotalPensiunPlatinum),
            'total_pensiun_diamond' => formatRupiah($countTotalPensiunDiamond),
        ];

        return response()->json([
            'status' => true,
            'data' => $results,
            200
        ]);
    }
}
