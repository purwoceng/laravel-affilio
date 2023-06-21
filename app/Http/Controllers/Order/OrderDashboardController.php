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
        $status = $request->status;

        $dataAffiliasi = DB::table('product_shared');
        $totalOmzet = DB::table('orders');
        $dataSupplierPrice = DB::table('orders');
        $dataOrder =  DB::table('orders');
        $dataUnpaid = Order::where('status', 'unpaid');
        $dataPaid = Order::where('status', 'paid');
        $dataAwaitingSupplier = Order::where('status', 'awaiting_supplier');
        $dataProcess = Order::where('status', 'on_process');
        $dataShipping = Order::where('status', 'on_return_shipping');
        $dataReceived = Order::where('status', 'received');
        $dataSuccess = Order::where('status', 'success');
        $dataCancel = Order::where('status', 'cancel');
        $dataCancelButUnpaid =  Order::where('status', 'cancel_unpaid');
        $dataComplain =  Order::where('status', 'complain');

        if (!empty($startDate) && !empty($endDate)) {
            $totalOmzet->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
            $dataAffiliasi->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
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
            $dataSupplierPrice->whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
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
        // Total Omzet : Harga produk + harga markup + ongkir
        $countTotalOmzetOngkir = ($dataSupplierPrice->sum('subtotal') + $totalOmzet->sum('shipping_cost')) ;
        // Total Omzet : Harga produk + harga markup
        $countTotalOmzet = $dataSupplierPrice->sum('subtotal');
        // Harga Supplier : Harga produk asli dari baleomol
        $countTotalSupplierPrice = $dataSupplierPrice->sum('affilio_value');
        // Bonus Profit : Harga Markup - Harga Asli
        $countTotalBonusProfit = ($dataSupplierPrice->sum('value') - $dataSupplierPrice->sum('affilio_value')) ;
        // Profit Member : diambil dari 75% harga markup
        $countTotalProfitKeuntungan =($dataSupplierPrice->sum('value') - $dataSupplierPrice->sum('affilio_value')) * 0.75;
        // Profit Keuntungan : diambil dari 24% harga markup
        $countTotalProfitKeuntunganAffilio =($dataSupplierPrice->sum('value') - $dataSupplierPrice->sum('affilio_value')) * 0.24;
        // Cadangan Kerugian : 1 % dari Total Margin
        $countTotalCadanganKerugian =($dataSupplierPrice->sum('value') - $dataSupplierPrice->sum('affilio_value')) * 0.01;
        // Ongkos kirim 60% : ongkos 60% dari 100% ongkir masuk ke IdExpress
        $countTotalOngkir60 = 60 * $totalOmzet->sum('shipping_cost') / 100;
        // Ongkos kirim 30% : ongkor 30% dari 100% ongkir masuk ke perusahaan
        $countTotalOngkir30 = 30 * $totalOmzet->sum('shipping_cost') / 100;
        // Ongkos kirim 10% : ongkos 10% dari 100% ongkir masuk ke bonus member/cashback
        $countTotalOngkir10 = 10 * $totalOmzet->sum('shipping_cost') / 100;
        // Kode unik : kode unik dikembalikan ke member
        $countTotalUniqueCode = 0;
        // Biaya lanyanan : biaya dari midtrans
        $countTotalServiceFee = $totalOmzet->sum('fee');
        // Keuntungan Affiliasi Produk Member
        $countTotalAffiliasiProfit = $dataAffiliasi->sum('markup_price') * $dataAffiliasi->sum('sold');


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
            'total_omzet_ongkir' => formatRupiah($countTotalOmzetOngkir),
            'supplier_price' => formatRupiah($countTotalSupplierPrice),
            'bonus_profit' => formatRupiah($countTotalBonusProfit),
            'Affiliasi_profit' => formatRupiah($countTotalAffiliasiProfit),
            'profit_keuntungan' => formatRupiah($countTotalProfitKeuntungan),
            'profit_keuntungan_affilio' => formatRupiah($countTotalProfitKeuntunganAffilio),
            'cadangan_kerugian_affilio' => formatRupiah($countTotalCadanganKerugian),
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
