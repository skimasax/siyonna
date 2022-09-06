<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //
    public function totalusers(Request $req)
    {

        try {

            $data = User::get();
            $code = 200;
            $response = [
                'data' => $data,
                'status' => 'success',
            ];
        } catch (\Throwable $th) {
            $response = [
                'data' => [],
                'status' => 'error',
                'message' => $th->getMesssage(),
            ];
            $code = 400;
        }

        return response()->json($response, $code);
    }

    public function getUserDetails(Request $req, $id)
    {
        try {

            $user = User::where('id', $id)->first();
            $wallet = $user->wallet;
            $transaction = $user->transaction;

            $code = 200;

            $response = [
                'data' => $user,
                'status' => 'success'
            ];
        } catch (\Throwable $th) {
            $response = [
                'data' => [],
                'message' => $th->getMessage(),
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }
    
}
