<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqCategoryRequest;
use Illuminate\Http\Request;
use App\Models\FaqCategory;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all categories from the database
        $categories = FaqCategory::all();

        // Use the API helper for response
        return wt_api_json_success($categories, null, 'FAQ categories retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqCategoryRequest $request)
    {
        // Validation passed, create a new FAQ category
        $category = FaqCategory::create($request->validated());

        // Use the API helper for response
        return wt_api_json_success($category, null, 'FAQ category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the category based on the provided $id
        $category = FaqCategory::find($id);

        // Check if the category was found
        if (!$category) {
            return wt_api_json_error('Category not found', 404);
        }

        // Use the API helper for response
        return wt_api_json_success($category, null, 'Category retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $category = FaqCategory::find($id); // Find the category by ID

            if (!$category) {
                return wt_api_json_error('Category not found', 404);
            }

            $category->update($request->all()); // Update the category

            return wt_api_json_success('FAQ category updated successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while updating the category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the FAQ category based on the provided $id
        $category = FaqCategory::find($id);

        // Check if the FAQ category was found
        if (!$category) {
            return wt_api_json_error('FAQ category not found', 404);
        }

        try {
            // Delete the FAQ category
            $category->delete();

            // Use the API helper for response
            return wt_api_json_success(null, null, 'FAQ category deleted successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while deleting the FAQ category');
        }
    }
}
