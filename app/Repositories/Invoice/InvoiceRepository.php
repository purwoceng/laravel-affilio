<?php

namespace App\Repositories\Invoice;

use App\Models\Invoice;
use App\Repositories\Interfaces\Invoice\InvoiceRepositoryInterface;

class InvoiceRepository implements InvoiceRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getInvoices($limit, $start)
    {
        return Invoice::where('publish', '1')->offset($start)->limit($limit);
    }

    public function getTotalInvoices()
    {
        return Invoice::where('publish', '1')->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getInvoices($limit, $start);
        $totalData = $this->getTotalInvoices();
        $totalFiltered = $totalData;

        if ($request->filled('code')) {
            $keyword = $request->get('code');
            $getQuery->where('code', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $getQuery->where('username', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('methode')) {
            $keyword = $request->get('methode');
            $getQuery->where('payment_method', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('status')) {
            $keyword = $request->get('status');
            $getQuery->where('status', $keyword);
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        $getInvoices = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($getInvoices)) {
            foreach ($getInvoices  as $key => $invoice) {
                $id = $invoice->id;
                $code = $invoice->code;
                $username = $invoice->username;
                $nama = $invoice->member_id;
                $subtotal = $invoice->subtotal;
                $shipping_cost = $invoice->shipping_cost;
                $total = $invoice->total;
                $status = $invoice->status;
                $whatsapp = $invoice->whatsapp_number;
                $payment_method = $invoice->payment_method;
                $type = $invoice->type;

                $data[] = compact(
                    'id',
                    'code',
                    'username',
                    'nama',
                    'subtotal',
                    'shipping_cost',
                    'total',
                    'status',
                    'whatsapp',
                    'payment_method',
                    'type',
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
