<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    /**
     * @param Request $request
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
                'password' => 'required|confirmed',
                'name' => 'required|string',            ]
        );

        if ($validator->fails()) {
            return $validator->errors();
        }

        User::query()->create($data);


        return general_response([], 'Success');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();

            $token = $user->createToken("Token")->accessToken;

            return general_response([
                'token' => $token,
                'user' => new UserResource($user)
            ]);
        }
        else{
            return general_response([
            ],"can't make login");
        }
        return general_response([
        ],"logged");
    }
}
