<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin'])->except(['index', 'show']);
    } //end of constructor


    public function index()
    {
        return Product::latest()->paginate(9);
    } //end of index


    public function create()
    {
        return Brand::select('title', 'id')->get();
    } //end of create


    public function store(StoreProductRequest $request)
    {
        $request['user_id'] = auth()->id();
        Product::create($request->all());
        return response()->json('success', 200);
    } //end of store


    public function show(Product $product)
    {
        $product->brand = $product->brand;
        $product->user = $product->user;
        return $product;
    } //end of show


    public function edit(Product $product)
    {
        return response()->json([
            'product' => $product,
            'brands' => Brand::select('title', 'id')->get()
        ]);
    } //end of edit


    public function update(UpdateProductRequest $request, Product $product)
    {
        $request['user_id'] = auth()->id();
        $product->update($request->all());
        return response()->json('success', 200);
    } //end of update


    public function destroy(Product $product)
    {
        $product->orders()->detach();
        $product->delete();
        return response()->json('success', 200);
    } //end of destroy
}
