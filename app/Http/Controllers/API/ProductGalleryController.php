<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\ProductGallery;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product_galleries = ProductGallery::paginate(10);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data Product Gallery berhasil ditampilkan'
            ],
            'data' => $product_galleries
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request, Product $product)
    {
        $files = $request->file('files');

        if($request->hasFile('files'))
        {
            foreach ($files as $file) {
                $path = $file->store('public/gallery');

                ProductGallery::create([
                    'products_id' => $product->id,
                    'url' => $path
                ]);
            }
        }

        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data Product Gallery berhasil ditambahkan',
            ],
            'data' => $product,
        ];

        return response()->json($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function show(ProductGallery $productGallery)
    {
        $product_galleries = ProductGallery::find($productGallery->id);
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data Product Gallery berhasil ditampilkan',
            ],
            'data' => $product_galleries,
        ];
        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductGallery $productGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductGallery $productGallery)
    {
        $product_galleries = ProductGallery::find($productGallery->id);
        $product_galleries->delete();
        $response = [
            'meta' => [
                'status' => 'success',
                'code' => 200,
                'message' => 'Data Product Gallery berhasil dihapus',
            ],
            'data' => $product_galleries,
        ];
        return response()->json($response, 200);
    }
}
