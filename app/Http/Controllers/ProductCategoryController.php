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
        $categories = ProductCategory::all();
        return wt_api_json_success($categories, null, 'Product categories retrieved successfully');
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
    public function store(ProductCategoryRequest $request)
    {
        $category = ProductCategory::create($request->validated());
        return wt_api_json_success($category, null, 'Product category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return wt_api_json_error('Product category not found', 404);
        }

        return wt_api_json_success($category, null, 'Product category retrieved successfully');
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
    public function update(ProductCategoryRequest $request, string $id)
    {
        $category = ProductCategory::find($id);

        if (!$category) {
            return wt_api_json_error('Product category not found', 404);
        }

        try {
            $category->update($request->validated());
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
        $category = ProductCategory::find($id);

        if (!$category) {
            return wt_api_json_error('Product category not found', 404);
        }

        try {
            $category->delete();
            return wt_api_json_success(null, null, 'Product category deleted successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while deleting the product category');
        }
    }
}
