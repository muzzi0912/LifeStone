<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all product categories from the database
        $categories = ProductCategory::all();

        // Use the API helper for response
        return wt_api_json_success($categories, null, 'Product categories retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        // Validation passed, create a new product category
        $category = ProductCategory::create($request->validated());

        // Use the API helper for response
        return wt_api_json_success($category, null, 'Product category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the product category based on the provided $id
        $category = ProductCategory::find($id);

        // Check if the product category was found
        if (!$category) {
            return wt_api_json_error('Product category not found', 404);
        }

        // Use the API helper for response
        return wt_api_json_success($category, null, 'Product category retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Find the product category by ID
        $category = ProductCategory::find($id);

        // Check if the product category was found
        if (!$category) {
            return wt_api_json_error('Product category not found', 404);
        }

        try {
            // Update the product category with all data from the request
            $category->update($request->all());

            // Use the API helper for response
            return wt_api_json_success($category, null, 'Product category updated successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while updating the product category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the product category based on the provided $id
        $category = ProductCategory::find($id);

        // Check if the product category was found
        if (!$category) {
            return wt_api_json_error('Product category not found', 404);
        }

        try {
            // Delete the product category
            $category->delete();

            // Use the API helper for response
            return wt_api_json_success(null, null, 'Product category deleted successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while deleting the product category');
        }
    }
}