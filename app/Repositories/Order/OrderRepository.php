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

    public function getData($limit, $start)
    {
        return Order::whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return Order::whereNull('deleted_at')->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getData($limit, $start);
        $totalData = $this->getTotalData();
        $totalFiltered = $totalData;

        $getResults = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($getResults)) {
            foreach ($getResults  as $key => $order) {
                $id = $order->id;
                $originInvoiceCode = $order->origin_invoice_code ?? '-';
                $originOrderCode = $order->origin_order_code ?? '-';
                $invoiceCode = $order->invoice_code ?? '-';
                $orderCode = $order->order_code ?? '-';
                $name = $order->name;
                $waybillNumber = $order->waybill_number ?? '-';
                $shippingCost = $order->shipping_cost;
                $subTotal = $order->subtotal;
                $total = $order->total;
                $phone = $order->phone;
                $address = $order->address;
                $status = $order->status;
                $paymentStatus = $order->payment_status;
                $shippingCourier = $order->shipping_courier;
                $shippingService = $order->shipping_service;
                $courier = $shippingCourier . ' - ' . $shippingService;
                $dateCreated = $order->created_at->format('Y-m-d H:i:s');

                $data[] = array(
                    'id' => $id,
                    'origin_invoice_code' => $originInvoiceCode,
                    'origin_order_code' => $originOrderCode,
                    'invoice_code' => $invoiceCode,
                    'order_code' => $orderCode,
                    'name' => $name,
                    'waybill_number' => $waybillNumber,
                    'shipping_cost' => $shippingCost,
                    'subtotal' => $subTotal,
                    'total' => $total,
                    'phone' => $phone,
                    'address' => $address,
                    'status' => $status,
                    'payment_status' => $paymentStatus,
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
