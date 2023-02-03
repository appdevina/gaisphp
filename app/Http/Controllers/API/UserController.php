<?php

use Faker\Guesser\Name;

namespace App\Http\Controllers\API;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller{
    public function login(Request $request)
    {
       try {
            $request->validate([
                'username' => 'required',
                'password' => 'required'
            ]);

            $credentials = request(['username','password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ],  'Authentication Failed', 500
            );
            }

            $user = User::where('username', $request->username)->first();

            if(!Hash::check($request->password, $user->password, [])){
                throw new \Exception('Invalid Credentials');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user
            ],  'Authenticated'
            );

        } catch (Exception $error) {
            return ResponseFormatter::error([
                'message' => 'Something went wrong',
                //'error' => $error
            ],  'Authentication Failed', 500
        );
        $error->getMessage();
       } 
    }

    public function fetch(Request $request)
    {
        return ResponseFormatter::success(Auth::user(),'Data profile user berhasil diambil');
    }
}