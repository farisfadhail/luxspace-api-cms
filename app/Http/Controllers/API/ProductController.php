<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(10);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data Product berhasil ditampilkan'
            ],
            'data' => $products
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validator = $request->validate();

        if(!$validator) {
            $response = [
                'meta' => [
                    'status' => 'error',
                    'code' => 422,
                    'message' => 'Data product gagal ditambahkan',
                ]
            ];
            return response()->json($response, 422);
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        $product['slug'] = Str::slug($request->name);


        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data product berhasil ditambahkan',
            ],
            'data' => $product,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::find($product->id);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data product berhasil ditampilkan',
            ],
            'data' => $product,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product = Product::find($product->id);
        $validator = $request->validate();

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        $product['slug'] = Str::slug($request->name);


        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data product berhasil diubah',
            ],
            'data' => $product,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product = Product::find($product->id);
        $product->delete();
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data product berhasil dihapus',
            ],
            'data' => $product,
        ];
        return response()->json($response, 200);
    }
}
