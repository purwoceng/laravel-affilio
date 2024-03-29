<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use Illuminate\Support\Optional;

class OrderRepository implements OrderRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getData($limit, $start, $startDate, $endDate)
    {
        return Order::whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate)->offset($start)->limit($limit);
    }

    public function getTotalData($startDate, $endDate)
    {
        return Order::whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        if (!empty($request->date_range)) {
            $dateRange = $request->date_range;
            $date = explode("/", $dateRange);;
            $startDate = $date[0];
            $endDate = $date[1];
        } else {
            $now = date('Y-m-d');
            $startDate = $now;
            $endDate = $now;
        }

        $getQuery = $this->getData($limit, $start, $startDate, $endDate);
        // $totalData = $this->getTotalData($startDate, $endDate);
        $getQueryTotal = $this->getTotalData($startDate, $endDate);
        // $totalFiltered = $totalData;

        if ($request->filled('customer_name')) {
            $keyword = $request->get('customer_name');
            $getQuery->where('customer_name', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('customer_name', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }

        if ($request->filled('code')) {
            $keyword = $request->get('code');
            $getQuery->where('code', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('code', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $getQuery->where('username', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('username', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }

        if ($request->filled('invoice_code')) {
            $keyword = $request->get('invoice_code');
            $getQuery->where('invoice_code', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('invoice_code', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }

        if ($request->filled('baleo_order_code')) {
            $keyword = $request->get('baleo_order_code');
            $getQuery->where('baleo_order_code', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('baleo_order_code', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }

        if ($request->filled('phone')) {
            $keyword = $request->get('phone');
            $getQuery->where('phone', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('phone', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }
        if ($request->filled('resi')) {
            $keyword = $request->get('resi');
            $getQuery->where('resi', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('resi', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }

        if ($request->filled('invoice_id')) {
            $keyword = $request->get('invoice_id');
            $getQuery->where('invoice_id', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('invoice_id', 'like', '%' . $keyword . '%');
            // $totalData = $getQuery->count();
            // $totalFiltered = $totalData;
        }

        if ($request->filled('status')) {
            $keyword = $request->get('status');
            if ($keyword != 'all') {
                $getQuery->where('status', $keyword);
                $getQueryTotal->where('status', $keyword);
                // $totalData = $getQuery->count();
                // $totalFiltered = $totalData;
            }
        }
        if ($request->filled('baleomol_status')) {
            $keyword = $request->get('baleomol_status');
            if ($keyword != 'all') {
                $getQuery->where('baleomol_status', $keyword);
                $getQueryTotal->where('baleomol_status', $keyword);
                // $totalData = $getQuery->count();
                // $totalFiltered = $totalData;
            }
        }
        if ($request->filled('date_paid')) {
            $keyword = $request->get('date_paid');
            if ($keyword != 'all') {
                $getQuery->where('date_paid', $keyword);
                $getQueryTotal->where('date_paid', $keyword);
            }
            if ($keyword == 'paid') {
                $getQuery->whereNotNull('date_paid','=','is not null', $keyword);
                $getQueryTotal->whereNotNull('date_paid','=','is not null', $keyword);
            }
            if ($keyword == 'unpaid') {
                $getQuery->whereNull('date_paid','=','', $keyword);
                $getQueryTotal->whereNull('date_paid','=','', $keyword);
            }
        }

        $totalData = $getQueryTotal->count();
        $totalFiltered = $totalData;
        $getResults = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($getResults)) {
            foreach ($getResults  as $key => $order) {
                $id = $order->id;
                $invoiceCode = $order->invoice_code;
                $baleoOrderCode = $order->baleo_order_code ?? '-';
                $code = $order->code;
                $username = $order->username;
                $name = $order->customer_name;
                $resi = !empty($order->resi) ?  $order->resi : '-';
                $shippingCost = $order->shipping_cost;
                $fee = $order->fee ?? '-';
                $affilio_subtotal = $order->affilio_subtotal ?? '-';
                $subtotal = $order->value;
                $total = $order->total;
                $phone = $order->phone;
                $address = $order->address;
                $baleomolStatus = $order->baleomol_status;
                $status = $order->status;
                $payment_status = $order->payment_status;
                $shippingCourier = strtoupper($order->shipping_courier);
                $shippingService = $order->shipping_service ?? '-';
                $courier = $shippingCourier . ' - ' . $shippingService;
                $dateCreated = date(' d F Y H:i', strtotime($order->date_created));
                // $datePaid = optional($order->date_paid);
                $datePaid = optional($order->date_paid)->format('d F Y H:i');

                $lastSyncedDate = $order->date_last_synced;
                $lastSyncedStamp = 900;
                $lastSyncedElapsed = 'Belum pernah';

                if (!!$lastSyncedDate) {
                    $timeline = timeLine($lastSyncedDate);
                    $lastSyncedStamp = $timeline['timestamp'] ?? $lastSyncedStamp;
                    $lastSyncedElapsed = $timeline['elapsed'] ?? $lastSyncedElapsed;
                }

                $data[] = array(
                    'id' => $id,
                    'invoice_code' => $invoiceCode,
                    'baleo_order_code' => $baleoOrderCode,
                    'code' => $code,
                    'username' => $username,
                    'name' => $name,
                    'resi' => $resi,
                    'shipping_cost' => formatRupiah($shippingCost),
                    'fee' => formatRupiah($fee),
                    'affilio_subtotal' => formatRupiah($affilio_subtotal),
                    'subtotal' => formatRupiah($subtotal),
                    'total' =>  formatRupiah($total),
                    'phone' => $phone,
                    'address' => $address,
                    'baleomol_status' => $baleomolStatus,
                    'status' => $status,
                    'payment_status' => $payment_status,
                    'courier' => $courier,
                    'date_created' => $dateCreated,
                    'date_paid' => $datePaid ,
                    'last_synced_stamp' => $lastSyncedStamp,
                    'last_synced_elapsed' => $lastSyncedElapsed,
                    'actions' => $id,
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return response()->json($result);
        }

    // public function getData1($limit, $start, $startDate1, $endDate1)
    // {
    //     return Order::whereDate('date_paid', '>=', $startDate1)->whereDate('date_paid', '<=', $endDate1)->offset($start)->limit($limit);
    // }

    // public function getTotalData1($startDate1, $endDate1)
    // {
    //     return Order::whereDate('date_paid', '>=', $startDate1)->whereDate('date_paid', '<=', $endDate1);
    // }

    // public function getDataTable1($request)
    // {
    //     $limit = $request->input('length');
    //     $start = $request->input('start');

    //     if (!empty($request->date_range_paid)) {
    //         $dateRange1 = $request->date_range_paid;
    //         $date = explode("/", $dateRange1);;
    //         $startDate1 = $date[0];
    //         $endDate1 = $date[1];
    //     } else {
    //         $now = date('Y-m-d');
    //         $startDate1 = $now;
    //         $endDate1 = $now;
    //     }

    //     $getQuery = $this->getData1($limit, $start, $startDate1, $endDate1);
    //     // $totalData = $this->getTotalData($startDate, $endDate);
    //     $getQueryTotal = $this->getTotalData1($startDate1, $endDate1);
    //     // $totalFiltered = $totalData;

    //     if ($request->filled('customer_name')) {
    //         $keyword = $request->get('customer_name');
    //         $getQuery->where('customer_name', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('customer_name', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }

    //     if ($request->filled('code')) {
    //         $keyword = $request->get('code');
    //         $getQuery->where('code', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('code', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }

    //     if ($request->filled('username')) {
    //         $keyword = $request->get('username');
    //         $getQuery->where('username', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('username', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }

    //     if ($request->filled('invoice_code')) {
    //         $keyword = $request->get('invoice_code');
    //         $getQuery->where('invoice_code', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('invoice_code', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }

    //     if ($request->filled('baleo_order_code')) {
    //         $keyword = $request->get('baleo_order_code');
    //         $getQuery->where('baleo_order_code', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('baleo_order_code', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }

    //     if ($request->filled('phone')) {
    //         $keyword = $request->get('phone');
    //         $getQuery->where('phone', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('phone', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }
    //     if ($request->filled('resi')) {
    //         $keyword = $request->get('resi');
    //         $getQuery->where('resi', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('resi', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }

    //     if ($request->filled('invoice_id')) {
    //         $keyword = $request->get('invoice_id');
    //         $getQuery->where('invoice_id', 'like', '%' . $keyword . '%');
    //         $getQueryTotal->where('invoice_id', 'like', '%' . $keyword . '%');
    //         // $totalData = $getQuery->count();
    //         // $totalFiltered = $totalData;
    //     }

    //     if ($request->filled('status')) {
    //         $keyword = $request->get('status');
    //         if ($keyword != 'all') {
    //             $getQuery->where('status', $keyword);
    //             $getQueryTotal->where('status', $keyword);
    //             // $totalData = $getQuery->count();
    //             // $totalFiltered = $totalData;
    //         }
    //     }
    //     if ($request->filled('baleomol_status')) {
    //         $keyword = $request->get('baleomol_status');
    //         if ($keyword != 'all') {
    //             $getQuery->where('baleomol_status', $keyword);
    //             $getQueryTotal->where('baleomol_status', $keyword);
    //             // $totalData = $getQuery->count();
    //             // $totalFiltered = $totalData;
    //         }
    //     }
    //     if ($request->filled('date_paid')) {
    //         $keyword = $request->get('date_paid');
    //         if ($keyword != 'all') {
    //             $getQuery->where('date_paid', $keyword);
    //             $getQueryTotal->where('date_paid', $keyword);
    //         }
    //         if ($keyword == 'paid') {
    //             $getQuery->whereNotNull('date_paid','=','is not null', $keyword);
    //             $getQueryTotal->whereNotNull('date_paid','=','is not null', $keyword);
    //         }
    //         if ($keyword == 'unpaid') {
    //             $getQuery->whereNull('date_paid','=','', $keyword);
    //             $getQueryTotal->whereNull('date_paid','=','', $keyword);
    //         }
    //     }

    //     $totalData = $getQueryTotal->count();
    //     $totalFiltered = $totalData;
    //     $getResults = $getQuery->orderBy('id', 'desc')->get();

    //     $data = [];

    //     if (!empty($getResults)) {
    //         foreach ($getResults  as $key => $order) {
    //             $id = $order->id;
    //             $invoiceCode = $order->invoice_code;
    //             $baleoOrderCode = $order->baleo_order_code ?? '-';
    //             $code = $order->code;
    //             $username = $order->username;
    //             $name = $order->customer_name;
    //             $resi = !empty($order->resi) ?  $order->resi : '-';
    //             $shippingCost = $order->shipping_cost;
    //             $fee = $order->fee ?? '-';
    //             $affilio_subtotal = $order->affilio_subtotal ?? '-';
    //             $subtotal = $order->value;
    //             $total = $order->total;
    //             $phone = $order->phone;
    //             $address = $order->address;
    //             $baleomolStatus = $order->baleomol_status;
    //             $status = $order->status;
    //             $payment_status = $order->payment_status;
    //             $shippingCourier = strtoupper($order->shipping_courier);
    //             $shippingService = $order->shipping_service ?? '-';
    //             $courier = $shippingCourier . ' - ' . $shippingService;
    //             $dateCreated = date(' d F Y H:i', strtotime($order->date_created));
    //             // $datePaid = optional($order->date_paid);
    //             $datePaid = optional($order->date_paid)->format('d F Y H:i');

    //             $lastSyncedDate = $order->date_last_synced;
    //             $lastSyncedStamp = 900;
    //             $lastSyncedElapsed = 'Belum pernah';

    //             if (!!$lastSyncedDate) {
    //                 $timeline = timeLine($lastSyncedDate);
    //                 $lastSyncedStamp = $timeline['timestamp'] ?? $lastSyncedStamp;
    //                 $lastSyncedElapsed = $timeline['elapsed'] ?? $lastSyncedElapsed;
    //             }

    //             $data[] = array(
    //                 'id' => $id,
    //                 'invoice_code' => $invoiceCode,
    //                 'baleo_order_code' => $baleoOrderCode,
    //                 'code' => $code,
    //                 'username' => $username,
    //                 'name' => $name,
    //                 'resi' => $resi,
    //                 'shipping_cost' => formatRupiah($shippingCost),
    //                 'fee' => formatRupiah($fee),
    //                 'affilio_subtotal' => formatRupiah($affilio_subtotal),
    //                 'subtotal' => formatRupiah($subtotal),
    //                 'total' =>  formatRupiah($total),
    //                 'phone' => $phone,
    //                 'address' => $address,
    //                 'baleomol_status' => $baleomolStatus,
    //                 'status' => $status,
    //                 'payment_status' => $payment_status,
    //                 'courier' => $courier,
    //                 'date_created' => $dateCreated,
    //                 'date_paid' => $datePaid ,
    //                 'last_synced_stamp' => $lastSyncedStamp,
    //                 'last_synced_elapsed' => $lastSyncedElapsed,
    //                 'actions' => $id,
    //             );
    //         }
    //     }

    //     $result = [
    //         'draw' => intval($request->input('draw')),
    //         'recordsTotal' => intval($totalData),
    //         'recordsFiltered' => intval($totalFiltered),
    //         'data' => $data,
    //     ];

    //     return response()->json($result);
    // }
}
