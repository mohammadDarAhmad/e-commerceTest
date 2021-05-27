<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return Product::query()->get();
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
                'order_id' => 'required|exists:orders,id',
                'name' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        Product::query()->create($data);
        return 'Success';

    }


    public function update(Request $request, Product $product)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
                'order_id' => 'exists:orders,id',
                'name' => 'string'

            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        $product->update($data);
        return 'Success';
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

        } catch (\Exception $e) {
            dd($e->getMessage());

            logger($e->getMessage());
        }

        return 'Success';
    }
}
