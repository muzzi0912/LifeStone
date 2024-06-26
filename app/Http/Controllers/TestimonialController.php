<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all testimonials from the database
        $testimonials = Testimonial::all();

        // Use the API helper for response
        return wt_api_json_success($testimonials, null, 'Testimonials retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request)
    {
        try {
            // Handle image upload
            $imagePath = $request->file('client_image')->store('client_images', 'public');

            // Handle video upload
            $videoPath = $request->hasFile('video_file') ? $request->file('video_file')->store('testimonial_videos', 'public') : null;

            // Use validated data from TestimonialRequest
            $validatedData = $request->validated();

            // Create a new testimonial
            $testimonial = Testimonial::create([
                'testimonial' => $validatedData['testimonial'],
                'client_name' => $validatedData['client_name'],
                'client_designation' => $validatedData['client_designation'],
                'client_company' => $validatedData['client_company'],
                'client_image' => $imagePath,
                'facebook_link' => $validatedData['facebook_link'] ?? null,
                'instagram_link' => $validatedData['instagram_link'] ?? null,
                'twitter_link' => $validatedData['twitter_link'] ?? null,
                'linkedin_link' => $validatedData['linkedin_link'] ?? null,
                'video_file' => $videoPath,
                'is_published' => $request->input('is_published', false),
            ]);

            // Use the API helper for response
            return wt_api_json_success($testimonial, null, 'Testimonial created successfully');
        } catch (\Exception $e) {
            // Handle any exceptions that might occur
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while creating the testimonial');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Retrieve the testimonial based on the provided $id
        $testimonial = Testimonial::find($id);

        // Check if the testimonial was found
        if (!$testimonial) {
            return wt_api_json_error("Testimonial not found", 404);
        }

        // Use the API helper for response
        return wt_api_json_success($testimonial, null, 'Testimonial retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return wt_api_json_error('Testimonial not found', 404);
        }

        try {
            $testimonial->update($request->all());

            return wt_api_json_success('Testimonial updated successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while updating the testimonial');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonial = Testimonial::find($id);

        if (!$testimonial) {
            return wt_api_json_error('Testimonial not found', 404);
        }

        try {
            $testimonial->delete();

            return wt_api_json_success('Testimonial deleted successfully');
        } catch (\Exception $e) {
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while deleting the testimonial');
        }
    }
}
