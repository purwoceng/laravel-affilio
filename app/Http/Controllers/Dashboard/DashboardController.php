<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Fund;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Order;
use Illuminate\Support\Facades\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $total_memberr = Member::select(DB::raw("CAST(sum(publish) as int) as total_member"))
                        ->GroupBy(DB::raw("Month(created_at)"))
                        ->pluck('total_member');

        $bulan = Member::select(DB::raw("MONTHNAME(created_at) as bulan"))
                ->GroupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('bulan');

        $total_margin = Order::select(DB::raw("CAST(sum(value - affilio_value) as int) as total_margin"))
                        //->where('status','success')
                        ->GroupBy(DB::raw("Month(created_at)"))
                        ->pluck('total_margin');

        $bulan_order = Order::select(DB::raw("MONTHNAME(created_at) as bulan_order"))
                       ->GroupBy(DB::raw("MONTHNAME(created_at)"))
                       ->pluck('bulan_order');


        return view('dashboard.index', compact('total_memberr','bulan', 'total_margin', 'bulan_order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getDashboard(Request $request)
    {

        $totalMember = Member::where('publish','1');
        $totalMargin = DB::table('orders');
        $totalOmzet = DB::table('orders');
        $totalBonusAcara1 = Fund::where('code', 'BRAT');
        $totalBonusAcara2 = Fund::where('code', 'BRAO');
        $totalBonusPensiun1 = Fund::where('code','BPSB');
        $totalBonusPensiun2 = Fund::where('code','BPSG');
        $totalBonusPensiun3 = Fund::where('code','BPSP');
        $totalBonusPensiun4 = Fund::where('code','BPSG');
        // Bonus Acara Ongkir
        $countTotalMember = $totalMember->count();
        $countMargin = ($totalMargin->sum('value') - $totalMargin->sum('affilio_value'));
        $countTotalOmzet = $totalOmzet->sum('subtotal');
        $countBonusAcara1 = $totalBonusAcara1->sum('value');
        $countBonusAcara2 = $totalBonusAcara2->sum('value');
        $countBonusAcara = $countBonusAcara1 + $countBonusAcara2;
        $countBonusPensiun1 = $totalBonusPensiun1->sum('value');
        $countBonusPensiun2 = $totalBonusPensiun2->sum('value');
        $countBonusPensiun3 = $totalBonusPensiun3->sum('value');
        $countBonusPensiun4 = $totalBonusPensiun4->sum('value');
        $countBonusPensiun = $countBonusPensiun1 + $countBonusPensiun2 + $countBonusPensiun3 + $countBonusPensiun4;

        $results = [
            'total_member' =>number_format($countTotalMember) ,
            'total_margin' => formatRupiah($countMargin),
            'total_bonus' => formatRupiah($countTotalOmzet),
            'total_bonus_acara' => formatRupiah($countBonusAcara),
            'total_bonus_pensiun' => formatRupiah($countBonusPensiun),
        ];

        return response()->json([
            'status' => true,
            'data' => $results,
            200
        ]);
    }

    // public function grafik()
    // {
    //     $total_member = Member::select(DB::raw("CAST(sum(total_member) as int) as total_member"))
    //     ->GroupBy(DB::raw("Month(created_at)"))
    //     ->pluck('total_member');

    //     $bulan = Member::slect(DB::raw("MONTHNAME(created_at) as bulan"))
    //     ->GroupBy(DB::raw("MONTHNAME(created_at)"))
    //     ->pluck('bulan');

    //     return view('dashboard.index', compact('total_member','bulan'));
    // }
}
