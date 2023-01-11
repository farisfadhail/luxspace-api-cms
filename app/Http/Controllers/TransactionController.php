<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax())
        {
            $query = Transaction::query();

            return DataTables::of($query)
                ->addcolumn('action', function($item){
                    return '
                        <a href="'. route('dashboard.transaction.show', $item->id) .'" class="border border-blue-500 bg-blue-500 text-white rounded-md px-2 py-1 mx-3 transition duration-500 ease select-none hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                            Show
                        </a>

                        <a href="'. route('dashboard.transaction.edit', $item->id) .'" class="border border-gray-500 bg-gray-500 text-white rounded-md px-2 py-1 mx-3 transition duration-500 ease select-none hover:bg-gray-600 focus:outline-none focus:shadow-outline">
                            Edit
                        </a>
                    ';
                })
                ->editColumn('total_price', function($item){
                    return number_format($item->total_price);
                })
                ->rawcolumns(['action'])
                ->make();
        }

        return view('pages.dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if(request()->ajax())
        {
            $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);

            return DataTables::of($query)
                ->editColumn('product.price', function($item){
                    return number_format($item->product->price);
                })
                ->rawcolumns(['action'])
                ->make();
        }

        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('pages.dashboard.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $data = $request->all();

        $transaction->update($data);

        return redirect()->route('dashboard.transaction.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
