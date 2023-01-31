<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderProduct;
use App\Repositories\Interfaces\Order\OrderRepositoryInterface;

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
        $order = Order::where('id',$id)->first();

        $orderProducts = OrderProduct::where('order_id',$id)->get();
        foreach ($orderProducts as $key => $value) {

            $orderProducts [] =[
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
                'fee' => formatRupiah($value->fee),
            ];
        }
        $order = [
            'code' => $order->code,
            'customer_name' => $order->customer_name,
            'subtotal' => $order->subtotal,
            'fee' => formatRupiah($order->fee),
            'shipping_cost' => formatRupiah($order->shipping_cost),
            'value' => formatRupiah($order->value),
            'total' => formatRupiah($order->total),
            'status' => $order->status,
            'phone' => $order->phone,
            'resi' => $order->resi,
            'shipping_courier' => $order->shipping_courier,
            'shipping_service' => $order->shipping_service,
            'address' => $order->address,
            'message' => $order->message ?? 'Tidak Ada Catatan',
            'date_created' =>  date('Y-m-d H:i', strtotime($order->date_created)),
        ];


        return response()->json([
            200,
            'status' =>true,
            'data' => [
                'order' => $order,
                'orderProducts' => $orderProducts,
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
}
