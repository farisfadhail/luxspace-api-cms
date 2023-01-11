<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
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
            $query = Product::query();

            return DataTables::of($query)
                ->addcolumn('action', function($item){
                    return '
                        <a href="'. route('dashboard.product.gallery.index', $item->id) .'" class="border border-blue-500 bg-blue-500 text-white rounded-md px-2 py-1 mx-3 transition duration-500 ease select-none hover:bg-blue-600 focus:outline-none focus:shadow-outline">
                            Gallery
                        </a>

                        <a href="'. route('dashboard.product.edit', $item->id) .'" class="border border-gray-500 bg-gray-500 text-white rounded-md px-2 py-1 mx-3 transition duration-500 ease select-none hover:bg-gray-600 focus:outline-none focus:shadow-outline">
                            Edit
                        </a>

                        <form class="inline-block" action="'. route('dashboard.product.destroy', $item->id) .'" method="POST">
                            <button class="border border-red-500 bg-red-500 text-white rounded-md px-2 py-1 mx-2 transition duration-500 ease select-none hover:bg-red-600 focus:outline-none focus:shadow-outline" >
                                Hapus
                            </button>
                        '. method_field('delete') . csrf_field() .'
                        </form>
                    ';
                })
                ->editColumn('price', function($item){
                    return number_format($item->price);
                })
                ->rawcolumns(['action'])
                ->make();
        }

        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        Product::create($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('pages.dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $product->update($data);

        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('dashboard.product.index');
    }
}
