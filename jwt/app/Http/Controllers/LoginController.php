<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login (Request $request) {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email|max:255',
                'password' => 'required|string|min:8|max:255'
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'msg' => $validator->errors()
            ],200);
        }

        if (!$token = Auth::guard('api')->attempt(['email' => $request->input('email'),'password' => $request->input('password')])) {
            return response()->json(['status' => 'Unauthorized'], 401);
        }

        return $this->responseWithToken($token);
    }

    private function responseWithToken ($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function user () {
        return response()->json(Auth::guard('api')->user());
    }
}
