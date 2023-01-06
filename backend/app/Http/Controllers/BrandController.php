<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Http\Requests\UpdateBrandRequest;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:admin'])->except('index');
    } //end of constructor


    public function index()
    {
        return Brand::latest()->get();
    } //end of index


    public function store(StoreBrandRequest $request)
    {
        $request['user_id'] = auth()->id();
        Brand::create($request->all());
        return response()->json('success', 200);
    } //end of store


    public function edit(Brand $brand)
    {
        return $brand;
    } //end of edit


    public function update(UpdateBrandRequest $request, Brand $brand)
    {
        $request['user_id'] = auth()->id();
        $brand->update($request->all());
        return response()->json('success', 200);
    } //end of update


    public function destroy(Brand $brand)
    {
        $brand->products()->delete();
        $brand->delete();
        return response()->json('success', 200);
    } //end pf destroy
}
