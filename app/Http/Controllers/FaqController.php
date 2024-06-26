<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Retrieve the selected category ID from the request
        $categoryId = $request->input('category_id');

        // Query to get FAQs with the selected category
        $faqs = Faq::when($categoryId, function (Builder $query, $categoryId) {
            $query->where('category_id', $categoryId);
        }) 
            ->with('category')
            ->get();

        return wt_api_json_success($faqs, null, 'FAQs retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        // Validation passed, create a new FAQ
        $faqData = $request->validated();

        // Set default value for is_published if not provided
        $faqData['is_published'] = $request->input('is_published', false);

        $faq = Faq::create($faqData);

        // Use the API helper for response
        return wt_api_json_success($faq, null, 'FAQ created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the FAQ based on the provided $id
        $faq = Faq::with('category')->find($id);

        // Check if the FAQ was found
        if (!$faq) {
            return wt_api_json_error('FAQ not found', 404);
        }

        // Use the API helper for response
        return wt_api_json_success($faq, null, 'FAQ retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $faq = Faq::find($id); // Find the FAQ by ID

            if (!$faq) {
                return wt_api_json_error('FAQ not found', 404);
            }

            $faq->update($request->all()); // Update the FAQ

            return wt_api_json_success('FAQ updated successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while updating the FAQ');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the FAQ based on the provided $id
        $faq = Faq::find($id);

        // Check if the FAQ was found
        if (!$faq) {
            return wt_api_json_error('FAQ not found', 404);
        }

        try {
            // Delete the FAQ
            $faq->delete();

            // Use the API helper for response
            return wt_api_json_success(null, null, 'FAQ deleted successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while deleting the FAQ');
        }
    }
}