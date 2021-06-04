<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductsOrdersCollection;
use App\Models\Order;
use App\Models\ProductsOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::query()->with('products')->get();
        return general_response(new  OrderCollection($orders));

    }

    public function productsOrder(Request $request, Order $order)
    {

        $productsOrder = ProductsOrder::query()->where('order_id', $order->id)->get();

        return general_response(new ProductsOrdersCollection($productsOrder));

    }

    public function show(Order $order)
    {
        $order = $order->with('products')->first();
        return general_response(new OrderResource($order));
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
                'customer_id' => 'required|exists:customers,id',
                'delivery_id' => 'required|exists:deliveries,id',
                'product_id' => 'required|exists:products,id',
                'order_id' => 'exists:orders,id',
                'name' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        if (!$request->has('orders_id')) {
            $order = Order::query()->create($data);
            $dataProducts['order_id'] = $order->id;
        } else {
            $dataProducts['order_id'] = $request["order_id"];
        }
        $dataProducts['product_id'] = $request['product_id'];
        ProductsOrder::query()->create($dataProducts);
        return general_response([], 'Success');

    }


    public function update(Request $request, Order $order)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
                'customer_id' => 'exists:customers,id',
                'delivery_id' => 'exists:deliveries,id',
                'name' => 'string'
            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        $order->update($data);
        return general_response([], 'Success');
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();

        } catch (\Exception $e) {
            dd($e->getMessage());

            logger($e->getMessage());
        }

        return general_response([], 'Success');
    }
}
