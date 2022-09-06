<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\WalletType;
use Illuminate\Http\Response;

class WalletController extends Controller
{
    //
    public function getAllWallet(Request $req)
    {
        try {
            $data = WalletType::get();

            $code = 200;

            $response = [
                'data' => $data,
                'status' => 'success'
            ];
        } catch (\Throwable $th) {
            $response = [
                'data' => [],
                'message' => $th->getMessage(),
                'status' => 'error'
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }
}
