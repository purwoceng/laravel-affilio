<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderDashboardController extends Controller
{
    public function getDashboard(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $dataOrder = Order::whereNull('deleted_at');
        $dataUnpaid = Order::where('status', 'unpaid')->whereNull('deleted_at');
        $dataPaid = Order::where('status', 'paid')->whereNull('deleted_at');
        $dataAwaitingSupplier = Order::where('status', 'awaiting_supplier')->whereNull('deleted_at');
        $dataProcess = Order::where('status', 'on_process')->whereNull('deleted_at');
        $dataShipping = Order::where('status', 'on_shipping')->whereNull('deleted_at');
        $dataReceived = Order::where('status', 'received')->whereNull('deleted_at');
        $dataSuccess = Order::where('status', 'success')->whereNull('deleted_at');
        $dataCancel = Order::where('status', 'cancel')->whereNull('deleted_at');
        $dataCancelButUnpaid =  Order::where('status', 'cancel_but_unpaid')->whereNull('deleted_at');
        $dataComplain =  Order::where('status', 'complain')->whereNull('deleted_at');


        if (!empty($startDate) && !empty($endDate)) {
            $dataOrder->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataUnpaid->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataPaid->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataAwaitingSupplier->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataProcess->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataShipping->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataReceived->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataSuccess->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataCancel->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataCancelButUnpaid->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
            $dataComplain->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
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
            'total_all' => $countOrder,
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
