<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;

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
        return Order::whereDate('date_created', '>=', $startDate)->whereDate('date_created', '<=', $endDate)->get()->count();
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
        $totalData = $this->getTotalData($startDate, $endDate);
        $totalFiltered = $totalData;

        if ($request->filled('customer_name')) {
            $keyword = $request->get('customer_name');
            $getQuery->where('customer_name', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('code')) {
            $keyword = $request->get('code');
            $getQuery->where('code', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('phone')) {
            $keyword = $request->get('phone');
            $getQuery->where('phone', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }
        if ($request->filled('resi')) {
            $keyword = $request->get('resi');
            $getQuery->where('resi', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('invoice_id')) {
            $keyword = $request->get('invoice_id');
            $getQuery->where('invoice_id', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('status')) {
            $keyword = $request->get('status');
            if ($keyword != 'all') {
                $getQuery->where('status',$keyword);
                $totalData = $getQuery->count();
                $totalFiltered = $totalData;
            }
        }

        $getResults = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($getResults)) {
            foreach ($getResults  as $key => $order) {
                $id = $order->id;
                $invoiceId = $order->invoice_id;
                $code = $order->code;
                $name = $order->customer_name;
                $resi = !empty($order->resi) ?  $order->resi : '-';
                $shippingCost = $order->shipping_cost;
                $subtotal = $order->value;
                $total = $order->total;
                $phone = $order->phone;
                $address = $order->address;
                $status = $order->status;
                $shippingCourier = strtoupper($order->shipping_courier);
                $shippingService = $order->shipping_service ?? '-';
                $courier = $shippingCourier . ' - ' . $shippingService;
                $dateCreated = date('Y-m-d H:i', strtotime($order->date_created));
                $data[] = array(
                    'id' => $id,
                    'invoice_id' => $invoiceId,
                    'code' => $code,
                    'name' => $name,
                    'resi' => $resi,
                    'shipping_cost' => formatRupiah($shippingCost),
                    'subtotal' => formatRupiah($subtotal),
                    'total' =>  formatRupiah($total),
                    'phone' => $phone,
                    'address' => $address,
                    'status' => $status,
                    'courier' => $courier,
                    'date_created' => $dateCreated,
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
}
