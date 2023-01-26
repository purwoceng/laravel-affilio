<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class OrderDashboardController extends Controller
{
    public function getDashboard(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $totalOmzet = DB::table('orders');
        $dataOrder =  DB::table('orders');
        $dataUnpaid = Order::where('status', 'unpaid');
        $dataPaid = Order::where('status', 'paid');
        $dataAwaitingSupplier = Order::where('status', 'awaiting_supplier');
        $dataProcess = Order::where('status', 'on_process');
        $dataShipping = Order::where('status', 'on_shipping');
        $dataReceived = Order::where('status', 'received');
        $dataSuccess = Order::where('status', 'success');
        $dataCancel = Order::where('status', 'cancel');
        $dataCancelButUnpaid =  Order::where('status', 'cancel_but_unpaid');
        $dataComplain =  Order::where('status', 'complain');

        if (!empty($startDate) && !empty($endDate)) {
            $totalOmzet->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);

            $dataOrder->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataUnpaid->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataPaid->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataAwaitingSupplier->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataProcess->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataShipping->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataReceived->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataSuccess->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataCancel->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataCancelButUnpaid->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataComplain->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
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
        // Total Omzet : Harga produk + harga markup + kode unik + ongkir + biaya layanan
        $countTotalOmzet =  12312311;
        // Harga Supplier : Harga produk asli dari baleomol
        $countTotalSupplierPrice = 1000000;
        // Bonus Profit : Bonus profit diambil dari 75% dari markup
        $countTotalBonusProfit = 75 * $countTotalSupplierPrice / 100 ;
        // Profit Keuntungan : diambil dari 25% harga markup
        $countTotalProfitKeuntungan =1123131212;
        // Ongkos kirim 60% : ongkos 60% dari 100% ongkir masuk ke IdExpress
        $countTotalOngkir60 = 234234234;
        // Ongkos kirim 30% : ongkor 30% dari 100% ongkir masuk ke perusahaan
        $countTotalOngkir30 = 4353533535;
        // Ongkos kirim 10% : ongkos 10% dari 100% ongkir masuk ke bonus member/cashback
        $countTotalOngkir10 = 8868668634;
        // Kode unik : kode unik dikembalikan ke member
        $countTotalUniqueCode = 1144646345;
        // Biaya lanyanan : biaya dari midtrans
        $countTotalServiceFee = 12412412124;


        $countOrder = $dataOrder->count();
        $countOrderUnpaid = $dataUnpaid->count();
        $countPersenUnpaid = showPercent($countOrderUnpaid, $countOrder);
        $countOrderPaid = $dataPaid->count();
        $countPersenPaid = showPercent($countOrderPaid, $countOrder);
        $countAwatingSupplier = $dataAwaitingSupplier->count();
        $countPersenAwaitingSupplier = showPercent($countAwatingSupplier, $countOrder);
        $countProcess = $dataProcess->count();
        $countPersenProcess = showPercent($countProcess, $countOrder);
        $countShipping = $dataShipping->count();
        $countPersenShipping = showPercent($countShipping, $countOrder);
        $countReceived = $dataReceived->count();
        $countPersenReceived = showPercent($countReceived, $countOrder);
        $countSuccess = $dataSuccess->count();
        $countPersenSuccess = showPercent($countSuccess, $countOrder);
        $countCancel = $dataCancel->count();
        $countPersenCancel = showPercent($countCancel, $countOrder);
        $countCancelButUnpaid = $dataCancelButUnpaid->count();
        $countPersenCancelButUnpaid = showPercent($countCancelButUnpaid, $countOrder);
        $countComplain = $dataComplain->count();
        $countPersenComplain = showPercent($countComplain, $countOrder);



        $results = [
            'total_omzet' => formatRupiah($countTotalOmzet),
            'supplier_price' => formatRupiah($countTotalSupplierPrice),
            'bonus_profit' => formatRupiah($countTotalBonusProfit),
            'profit_keuntungan' => formatRupiah($countTotalProfitKeuntungan),
            'total_ongkir_60' => formatRupiah($countTotalOngkir60),
            'total_ongkir_30' => formatRupiah($countTotalOngkir30),
            'total_ongkir_10' => formatRupiah($countTotalOngkir10),
            'unique_code' => formatRupiah($countTotalUniqueCode),
            'service_fee' => formatRupiah($countTotalServiceFee),
            'total_order' => $countOrder,
            'total_unpaid' => $countOrderUnpaid,
            'total_persen_unpaid' => $countPersenUnpaid,
            'total_paid' => $countOrderPaid,
            'total_persen_paid' => $countPersenPaid,
            'total_awaiting_supplier' => $countAwatingSupplier,
            'total_persen_awaiting_supplier' => $countPersenAwaitingSupplier,
            'total_process' => $countProcess,
            'total_persen_process' => $countPersenProcess,
            'total_shipping' => $countShipping,
            'total_persen_shipping' => $countPersenShipping,
            'total_received' => $countReceived,
            'total_persen_received' => $countPersenReceived,
            'total_success' => $countSuccess,
            'total_persen_success' => $countPersenSuccess,
            'total_cancel' => $countCancel,
            'total_persen_cancel' => $countPersenCancel,
            'total_cancel_but_unpaid' => $countCancelButUnpaid,
            'total_persen_cancel_but_unpaid' => $countPersenCancelButUnpaid,
            'total_complain' => $countComplain,
            'total_persen_complain' => $countPersenComplain,
        ];

        return response()->json([
            'status' =>true,
            'data' => $results,
            200
        ]);
    }
}
