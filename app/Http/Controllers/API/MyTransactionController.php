<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MyTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myTransactions = Transaction::with(['user'])->where('users_id', Auth::user()->id);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data transaction berhasil ditampilkan'
            ],
            'data' => $myTransactions
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $myTransaction)
    {
        $myTransactionItems = TransactionItem::with(['product'])->where('transactions_id', $myTransaction->id);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data transaction berhasil ditampilkan',
            ],
            'data' => $myTransactionItems,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
