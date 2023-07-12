<?php

namespace App\Http\Controllers\Dana;

use App\Models\Fund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EventDashboardController extends Controller
{
    public function getDashboard(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $RewardTransaksi = Fund::where('code', 'BRAT')->where('is_active','1');
        $RewardOngkir = Fund::where('code', 'BRAO')->where('is_active','1');

        if (!empty($startDate) && !empty($endDate)) {
            $RewardTransaksi->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $RewardOngkir->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
        } else {
            return response()->json([
                'status' => false,
                'errors' => [
                    'title' => 'Date Not Found',
                    'messages' => 'Not any date range selected',
                    'icon' => 'error',
                ],
            ]);
        }

        // Bonus Acara Ongkir
        $countTotalRewardOngkir = $RewardOngkir->sum('value');
        // Bonus Acara Transaksi
        $countTotalRewardTransaksi = $RewardTransaksi->sum('value');

        // Total Bonus Acara = BRAO + BRAT
        $countTotalReward = $countTotalRewardOngkir + $countTotalRewardTransaksi;

        $results = [
            'total_reward' => formatRupiah($countTotalReward),
            'total_reward_ongkir' => formatRupiah($countTotalRewardOngkir),
            'total_reward_transaksi' => formatRupiah($countTotalRewardTransaksi),
        ];

        return response()->json([
            'status' => true,
            'data' => $results,
            200
        ]);
    }
}
