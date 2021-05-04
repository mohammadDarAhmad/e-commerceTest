<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function index(Request $request)
    {
        return Delivery::query()->get();
    }

    public function show(Delivery $delivery)
    {
        return $delivery;
    }

    public function store(Request $request)
    {
        $data = $request->all();
        Delivery::query()->create($data);
        return 'Success';

    }


    public function update(Request $request, Delivery $delivery)
    {
        $data = $request->all();
        $delivery->update($data);
        return 'Success';
    }

    public function destroy(Delivery $delivery)
    {

        try {

            $delivery->delete();

        } catch (\Exception $e) {

            logger($e->getMessage());
        }

        return 'Success';
    }
}
