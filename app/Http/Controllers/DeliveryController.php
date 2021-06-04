<?php

namespace App\Http\Controllers;

use App\Http\Resources\DeliveryCollection;
use App\Http\Resources\DeliveryResource;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        $delivers = Delivery::query()->with('orders')->get();
        return general_response(new DeliveryCollection($delivers));

    }

    public function show(Delivery $delivery)
    {
        return $delivery;
        return general_response(new DeliveryResource($delivery));

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
        Delivery::query()->create($data);
        return general_response([], 'Success');

    }


    public function update(Request $request, Delivery $delivery)
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
        $delivery->update($data);
        return general_response([], 'Success');
    }

    public function destroy(Delivery $delivery)
    {

        try {

            $delivery->delete();

        } catch (\Exception $e) {

            logger($e->getMessage());
        }

        return general_response([], 'Success');
    }
}
