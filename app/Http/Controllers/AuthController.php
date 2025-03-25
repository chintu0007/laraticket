<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ApiLoginRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use ApiResponses;
    public function login(ApiLoginRequest $request) {
                
        return $this->ok($request->get('email'));

        // return response()->json([
        //     'message' => 'Hello API!'
        // ], 200);
    }

    public function register() {
        return $this->ok('register');
    }
}
