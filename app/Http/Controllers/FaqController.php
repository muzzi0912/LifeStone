<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::with('category')->get();
        return wt_api_json_success($faqs, null, 'FAQs retrieved successfully');
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
    public function store(FaqRequest $request)
    {
        $faq = Faq::create($request->validated());
        return wt_api_json_success($faq, null, 'FAQ created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faq = Faq::with('category')->find($id);

        if (!$faq) {
            return wt_api_json_error("FAQ not found", 404);
        }

        return wt_api_json_success($faq, null, 'FAQ retrieved successfully');
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
        try {
            $faq = faq::find($id); // Find the faq by ID

            if (!$faq) {
                return wt_api_json_error('faq not found', 404);
            }

            $faq->update($request->all()); // Update the faq

            return wt_api_json_success('faq updated successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while updating the faq');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::find($id);

        if (!$faq) {
            return wt_api_json_error('FAQ not found', 404);
        }

        try {
            $faq->delete();
            return wt_api_json_success(null, null, 'FAQ deleted successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while deleting the FAQ');
        }
    }
}
