<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->get();
        return wt_api_json_success($products, null, 'Products retrieved successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        // Handle image upload and store paths in the database
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('product_images', 'public');
                $images[] = $path;
            }
        }

        // Create the product
        $productData = [
            'name' => $validatedData['name'],
            'slogan' => $validatedData['slogan'],
            'category_id' => $validatedData['category_id'],
            'short_description' => $validatedData['short_description'],
            'long_description' => $validatedData['long_description'],
            'images' => $images,
        ];

        $product = Product::create($productData);

        return wt_api_json_success($product, null, 'Product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return wt_api_json_error('Product not found', 404);
        }

        return wt_api_json_success($product, null, 'Product retrieved successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return wt_api_json_error('Product not found', 404);
        }

        $product->update($request->all());

        return wt_api_json_success('Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Retrieve the product based on the provided $id
        $product = Product::find($id);

        // Check if the product was found
        if (!$product) {
            return wt_api_json_error('Product not found', 404);
        }

        // // Delete associated images from storage
        // $images = json_decode($product->images, true);
        // foreach ($images as $image) {
        //     Storage::disk('public')->delete($image);
        // }

        // Delete the product
        $product->delete();

        // Use the API helper for response
        return wt_api_json_success('Product deleted successfully');
    }
}
