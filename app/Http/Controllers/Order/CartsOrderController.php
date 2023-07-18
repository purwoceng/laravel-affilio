<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\CartsOrder;
use App\Repositories\Order\CartsOrderRepository;
use Illuminate\Http\Request;

class CartsOrderController extends Controller
{
    protected $repository;

    public function __construct(CartsOrderRepository $cartsOrderRepository)
    {
        $this->repository = $cartsOrderRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->getDataTable($request);
        }
        return view('carts.index');
    }

    public function delete($id)
    {
        $carts = CartsOrder::findOrFail($id);
        $carts->delete();
        return redirect()->back()->with(['success' => 'User:  $carts->affiliator_username  Dihapus']);


    }
}
