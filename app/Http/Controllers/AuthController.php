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

class AuthController extends Controller
{


    //register users
    public function register(Request $req)
    {
        $validation = Validator::make($req->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validation->passes()) {

            $existinguser = User::where('email', $req->email)->first();

            if (isset($existinguser)) {
                $response = [
                    'data' => [],
                    'message' => 'Email Already Exist',
                    'status' => 'error'
                ];
                return response($response, 400);
            }


            $data = User::create([
                'firstname' => $req->firstname,
                'lastname' => $req->lastname,
                'email' => $req->email,
                'password' => Hash::make($req->password),
            ]);


            $token = $data->createToken('myapptoken')->plainTextToken;

            $response = [
                'data' => $data,
                'token' => $token,
                'status' => 'success',
                'message' => 'Signup Successfull'
            ];

            return response()->json($response, 200);
        } else {
            $response = [
                'data' => [],
                'status' => 'error',
                'message' => 'Kindly complete required field'
            ];

            return response()->json($response, 400);
        }
    }


    //user login
    public function login(Request $req)
    {
        $attributes = $req->validate([
            'email' => 'required|string|email',
            'password' => 'required'
        ]);

        try {
            //code...
            if (!Auth::attempt($attributes)) {
                $response = [
                    'message' => 'Invalid Credentials',
                    'status' => 'error'
                ];

                $code = 400;
            }

            $user = User::where('email', $req->email)->first();
            $token = $user->createToken('myapptoken')->plainTextToken;
            $code = 200;

            $response = [
                'data' => $user,
                'token' => $token,
                'message' => 'Login Successfully'
            ];
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'data' => [],
                'message' => $th->getMessage(),
                'status' => 'error'
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }

    //user logout
    public function logout(Request $req)
    {

        $id = Auth::id();

        Auth::user()->tokens()->where('id', $id)->delete();

        $response = [
            'message' => 'Logout Successfully',
            'status' => 'success',
        ];

        return response()->json($response, 200);
    }

    //total number of users
    public function totalUsers(Request $req)
    {
    }
}
