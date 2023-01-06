<?php

namespace App\Http\Controllers;

use App\Models\Order;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Requests\UpdateOrderStatusRequest;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api']);
        $this->middleware(['role:admin'])->only(['index', 'changeOrderStatus']);
    } //end of constructor


    public function index()
    {
        return Order::latest()->paginate(10);
    } //end of index


    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::create(['user_id' => auth()->id()]);
            $products = array_combine($request->products_ids, $request->products_amounts);
            $order->products()->sync($products);
            return response()->json(['success', 200]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error']);
        }
    } //end of store


    public function show(Order $order)
    {
        return $order;
    } //end of show


    public function edit(Order $order)
    {
        return $order;
    } //end of edit


    public function update(UpdateOrderRequest $request, Order $order)
    {
        DB::beginTransaction();
        try {
            $products = array_combine($request->products_ids, $request->products_amounts);
            $order->products()->sync($products);
            return response()->json(['success', 200]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error']);
        }
    } //end of update


    public function destroy(Order $order)
    {
        $order->products()->detach();
        $order->delete();
        return response()->json(['success', 200]);
    } //end of destroy


    public function changeOrderStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $order->update($request->all());
        return response()->json(['success', 200]);
    } //end of changeOrderStatus
}
