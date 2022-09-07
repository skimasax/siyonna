<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class TransactionController extends Controller
{
    //send money from wallet to another
    public function sendmoney(Request $req)
    {
        $id = Auth::id();

        $validator = Validator::make($req->all(), [
            'sending_wallet' => 'required',
            'receiving_wallet' => 'required',
            'amount' => 'required',
            'details' => 'required'
        ]);

        try {
            $sendingwallet = $req->sending_wallet;
            $receivingwallet = $req->receiving_wallet;
            $amount = $req->amount;
            $details = $req->details;

            //debit the sending wallet
            Wallet::create([
                'wallet_type_id' => $sendingwallet,
                'user_id' => $id,
                'debit' => $amount,
                'details' => $details
            ]);

            //credit the receiving wallet
            Wallet::create([
                'wallet_type_id' => $receivingwallet,
                'user_id' => $id,
                'credit' => $amount,
                'details' => $details
            ]);

            //insert into transactions
            Transaction::create([
                'user_id' => $id,
                'sending_wallet_type_id' => $sendingwallet,
                'receiving_wallet_type_id' => $receivingwallet,
                'particulars' => $details,
                'amount' => $amount
            ]);

            $response = [
                'message' => 'Transfer Successfully',
                'status' => 'success'
            ];

            $code = 200;
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
}
