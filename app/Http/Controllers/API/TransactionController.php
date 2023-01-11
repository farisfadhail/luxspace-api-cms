<?php

namespace App\Http\Controllers\API;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = Transaction::paginate(10);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data transaction berhasil ditampilkan'
            ],
            'data' => $transactions
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $validator = $request->validate();

        if(!$validator) {
            $response = [
                'meta' => [
                    'status' => 'error',
                    'code' => 422,
                    'message' => 'Data transaction gagal ditambahkan',
                ]
            ];
            return response()->json($response, 422);
        }

        $transaction = Transaction::create([
            'users_id' => $request->users_id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'courier' => $request->courier,
            'payment' => $request->payment,
            'payment_url' => $request->payment_url,
            'total_price' => $request->total_price,
            'status' => $request->status
        ]);


        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data transaction berhasil ditambahkan',
            ],
            'data' => $transaction,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transaction = Transaction::find($transaction->id);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data transaction berhasil ditampilkan',
            ],
            'data' => $transaction,
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
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $transaction = Transaction::find($transaction->id);
        $validator = $request->validate();

        $transaction->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone' => $request->phone,
            'courier' => $request->courier,
            'payment' => $request->payment,
            'payment_url' => $request->payment_url,
            'total_price' => $request->total_price,
            'status' => $request->status
        ]);


        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data transaction berhasil diubah',
            ],
            'data' => $transaction,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $transaction = Transaction::find($transaction->id);
        $transaction->delete();
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data transaction berhasil dihapus',
            ],
            'data' => $transaction,
        ];
        return response()->json($response, 200);
    }
}
