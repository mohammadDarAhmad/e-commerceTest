<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customers = Customer::query()->with('orders')->get();
        return general_response(new CustomerCollection($customers));

    }

    public function show(Customer $customer)
    {
        $customer = $customer->with('orders')->first();
        return general_response(new CustomerResource($customer));

    }

    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
                'name' => 'required|string'
            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        $data = $request->all();
        Customer::query()->create($data);
        return general_response([], 'Success');

    }


    public function update(Request $request, Customer $customer)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
                'name' => 'string'
            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
        $data = $request->all();
        $customer->update($data);
        return general_response([], 'Success');

    }

    public function destroy(Customer $customer)
    {

        try {
            $orders = $customer->orders()->count() > 0;

            if ($orders) {
                return "You can't remove this customer because he has placed an order";
            }
            $customer->delete();

        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        return general_response([], 'Success');

    }
}
