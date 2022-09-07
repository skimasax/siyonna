<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Models\User;
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

    //full details
    public function getFullDetails(Request $Req)
    {
        try {
            $data = [
                'totaluserscount' => $this->totalUsersCount(),
                'totalwalletcount' => $this->totalWalletCount(),
                'totalwalletbalance' => $this->totalWalletBalance(),
            ];

            $response = [
                'data' => $data,
                'status' => 'success'
            ];

            $code = 200;
        } catch (\Throwable $th) {
            $response = [
                'data' => [],
                'message' => $th->getMessage(),
                'status' => 'error',
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }

    //count of wallet
    public function totalWalletCount()
    {
        $data = WalletType::count();
        return $data;
    }

    //count of users
    public function totalUsersCount()
    {
        $data = User::count();
        return $data;
    }

    //total wallet balance
    public function totalWalletBalance()
    {
        $credit = Wallet::sum('credit');
        $debit = Wallet::sum('debit');

        $balance = $credit - $debit;

        return $balance;
    }

    //getting wallet details
    public function getWalletDetails(Request $req, $id)
    {
        try {
            $data = Wallet::where('wallet_type_id', $id)->first();
            $user = $data->user;
            $transaction = $data->transaction;


            $response = [
                'data' => $data,
                'status' => 'success',
            ];

            $code = 200;
        } catch (\Throwable $th) {
            //throw $th;
            $response = [
                'data' => [],
                'message' => $th->getMessage(),
                'status' => 'error',
            ];

            $code = 400;
        }

        return response()->json($response, $code);
    }
    
}
