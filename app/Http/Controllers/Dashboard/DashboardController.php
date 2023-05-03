<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Fund;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Member;
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
        return view('dashboard.index');
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
            'total_member' => $countTotalMember,
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
}
