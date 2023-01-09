<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreOrderRequest;
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
        return Order::withCount('products')->with('user')->latest()->paginate(10);
    } //end of index


    public function store(StoreOrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $order = Order::create(['user_id' => auth()->id()]);
            $products_ids = json_decode($request->products_ids);
            $products_amounts = json_decode($request->products_amounts);
            $products = [];
            foreach ($products_ids as $index => $product) {
                $products[$product] = ['amount' => $products_amounts[$index]];
            }
            $order->products()->sync($products);
            return response()->json(['success', 200]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error']);
        }
    } //end of store


    public function show(Order $order)
    {
        $order->products = $order->products;
        $order->user = $order->user;
        return $order;
    } //end of show


    public function edit(Order $order)
    {
        return $order;
    } //end of edit


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
