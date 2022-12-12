<?php

namespace App\Repositories\Invoice\Unpaid;

use App\Models\Invoice;
use App\Repositories\Interfaces\Invoice\Unpaid\InvoiceUnpaidRepositoryInterface;

class InvoiceUnpaidRepository implements InvoiceUnpaidRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getData($limit, $start)
    {
        return Invoice::where('status','unpaid')->where('publish', '1')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return Invoice::where('status','unpaid')->where('publish', '1')->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getData($limit, $start);
        $totalData = $this->getTotalData();
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

        $getResults = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($getResults)) {
            foreach ($getResults  as $key => $invoice) {
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
