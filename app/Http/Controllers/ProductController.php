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
    public function index(Request $request)
    {
        // Retrieve the selected category ID from the request
        $categoryId = $request->input('category_id');

        // Query to get products with the selected category
        $products = Product::when($categoryId, function ($query, $categoryId) {
            $query->where('category_id', $categoryId);
        })
            ->with('category')
            ->get();

        // Use the API helper for response
        return wt_api_json_success($products, null, 'Products retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    // In the ProductController
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
            'short_description' => $validatedData['short_description'],
            'long_description' => $validatedData['long_description'],
            'images' => $images,
            'is_published' => $request->input('is_published', false), // Default to false if not provided
        ];

        $product = Product::create($productData);

        // Attach categories to the product using a loop
        foreach ($validatedData['category_ids'] as $categoryId) {
            $product->categories()->attach($categoryId);
        }

        // Use the API helper for response
        return wt_api_json_success($product, null, 'Product created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the product based on the provided $id
        $product = Product::find($id);

        // Check if the product was found
        if (!$product) {
            return wt_api_json_error('Product not found', 404);
        }

        // Use the API helper for response
        return wt_api_json_success($product, null, 'Product retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the product by ID
        $product = Product::find($id);

        // Check if the product was found
        if (!$product) {
            return wt_api_json_error('Product not found', 404);
        }

        // Update the product
        $product->update($request->all());

        // Use the API helper for response
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

        // Delete the product
        $product->delete();

        // Use the API helper for response
        return wt_api_json_success('Product deleted successfully');
    }
}