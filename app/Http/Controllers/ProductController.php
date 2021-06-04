<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()->with('orders')->get();
        return general_response(new  ProductCollection($products));
    }

    public function show(Product $product)
    {
        $product = $product->with('orders')->first();
        return general_response(new ProductResource($product));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
                'serial' => 'required|string',
                'name' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        Product::query()->create($data);
        return general_response([], 'Success');

    }


    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
                'serial' => 'string',
                'name' => 'string'

            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        $product->update($data);
        return general_response([], 'Success');
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

        } catch (\Exception $e) {
            dd($e->getMessage());

            logger($e->getMessage());
        }

        return general_response([], 'Success');
    }
}
