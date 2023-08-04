<?php

namespace App\Http\Controllers\Order;

use App\Exports\OrderExport;
use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;
use Maatwebsite\Excel\Facades\Excel;
use App\Lib\Affilio\Rbmq;

class OrderController extends Controller
{

    private $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->orderRepository->getDataTable($request);
        }
        return view('orders.index');
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
        $order = Order::where('id', $id)->first();

        $orderProducts = OrderProduct::where('order_id', $id)->get();
        foreach ($orderProducts as $key => $value) {
            if ($value->options == '{}') {
                $variantName = '-';
            } else {
                $variant = json_decode($value->options);
                $variantName = $variant->name;
            }

            $resultOrderProducts[] = [
                'order_id' => $value->order_id,
                'product_name' => $value->product_name,
                'original_price' => formatRupiah($value->original_price),
                'price' => formatRupiah($value->price),
                'weight' => $value->weight,
                'amount' => $value->amount,
                'total_origin_price' => formatRupiah($value->total_origin_price),
                'total' => formatRupiah($value->total),
                'markup_price' => formatRupiah($value->markup_price),
                'selling_price' => formatRupiah($value->selling_price),
                'total' => formatRupiah($value->total),
                'total_original_price' => formatRupiah($value->total_original_price),
                'total_profit' => formatRupiah($value->total_profit),
                'total_profit_affiliator' => formatRupiah($value->total_profit_affiliator),
                'total_profit_baleomol' => formatRupiah($value->total_profit_baleomol),
                'total_weight' => $value->total_weight,
                'variant_name' => $variantName,
                'fee' => formatRupiah($value->fee),
            ];
        }
        $order = [
            'id' => $order->id,
            'invoice_code' => $order->invoice_code,
            'baleo_order_code' => $order->baleo_order_code ?? '-',
            'code' => $order->code,
            'username' => $order->username,
            'customer_name' => Str::ucfirst($order->customer_name),
            'fee' => formatRupiah($order->fee),
            'shipping_cost' => formatRupiah($order->shipping_cost),
            'subtotal_affilio' => formatRupiah($order->subtotal_affilio),
            'value' => formatRupiah($order->value),
            'total' => formatRupiah($order->total),
            'status' => $order->status,
            'phone' => $order->phone,
            'resi' => !empty($order->resi) ? $order->resi : '-',
            'shipping_courier' => $order->shipping_courier,
            'shipping_service' => $order->shipping_service,
            'address' => $order->address,
            'full_address' => $order->subdistrict . ', ' . $order->city . ', ' . $order->province,
            'message' => !empty($order->message) ? $order->message : 'Tidak Ada Catatan',
            'zip_code' => $order->zip_code ?? '-',
            'date_created' =>  date('Y-m-d H:i', strtotime($order->date_created)),
        ];


        return response()->json([
            200,
            'status' => true,
            'data' => [
                'order' => $order,
                'orderProducts' => $resultOrderProducts,
            ],
        ]);
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

    // public function verification(Request $request)
    // {
    //     if (!empty($request->id)) {

    //         $data = [
    //             'status' => 'success',
    //         ];
    //         Order::where('id', $request->id)->update($data);
    //         return response()->json([
    //             'status' => 'true',
    //             'title' => 'Berhasil Sukseskan Pesanan!',
    //             'message' => 'Berhasil melakukan sukseskan pesanan',
    //             'icon' => 'success',
    //         ]);
    //     } else {
    //         return response()->json([
    //             'status' => 'false',
    //             'title' => 'Gagal Suksesi !!',
    //             'message' => 'Gagal melakukan sukseskan pesanan',
    //             'icon' => 'warning',
    //         ]);
    //     }
    // }

    public function exportexcel(Request $request)
    {
        $dateRange = [];
        $status = '';

        if (isset($request->daterange1)) {
            $dateRange = explode('-', $request->daterange1);
            $dateRange = array_map(function ($item) {
                $date = trim($item);
                $date = strtotime($date);
                $date = date('Y-m-d H:i:s', $date);

                return $date;
            }, $dateRange);
        }

        if (isset($request->status1)) {
            $status = $request->status1;
        }

        ini_set('max_execution_time',600);
        ini_set('memory_limit',"-1");

        return Excel::download(new OrderExport($status, $dateRange), 'order.xlsx');
    }

    public function createpdf(Request $request)
    {
        if (!empty($request->id)) {
        $data = Order::where('id', $request->id)->first();
        $orderId = $data->id;
        $username = $data->username;
        $memberId = $data->member_id;

        //push to rbmq
        $rbmq = new Rbmq();
        $rbmq->createPdf($orderId, $username, $memberId);

        return response()->json([
            'status' => 'true',
            'title' => 'Berhasil membuat PDF Pesanan!',
            'message' => 'Berhasil Berhasil membuat PDF pesanan',
            'icon' => 'success',
        ]);
        } else {
        return response()->json([
            'status' => 'false',
            'title' => 'Gagal Berhasil membuat PDF !!',
            'message' => 'Gagal melakukan Berhasil membuat PDF',
            'icon' => 'warning',
        ]);
        }
    }
}
