<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return Order::query()->get();
    }

    public function show(Order $order)
    {
        return $order;
    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
                'customer_id' => 'required|exists:customers,id',
                'delivery_id' => 'required|exists:deliveries,id',
                'name' => 'required|string'

            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        Order::query()->create($data);
        return 'Success';

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
        return 'Success';
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();

        } catch (\Exception $e) {
            dd($e->getMessage());

            logger($e->getMessage());
        }

        return 'Success';
    }
}
