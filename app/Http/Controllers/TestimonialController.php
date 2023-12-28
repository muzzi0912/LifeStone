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
            $videoPath = null;
            if ($request->hasFile('video_file')) {
                $videoPath = $request->file('video_file')->store('testimonial_videos', 'public');
            }

            // Use validated data from TestimonialRequest
            $validatedData = $request->validated();

            // Create a new testimonial
            $testimonial = new Testimonial();
            $testimonial->testimonial = $validatedData['testimonial'];
            $testimonial->client_name = $validatedData['client_name'];
            $testimonial->client_designation = $validatedData['client_designation'];
            $testimonial->client_company = $validatedData['client_company'];
            $testimonial->client_image = $imagePath;
            $testimonial->facebook_link = $validatedData['facebook_link'] ?? null;
            $testimonial->instagram_link = $validatedData['instagram_link'] ?? null;
            $testimonial->twitter_link = $validatedData['twitter_link'] ?? null;
            $testimonial->linkedin_link = $validatedData['linkedin_link'] ?? null;
            $testimonial->video_file = $videoPath;
            $testimonial['is_published'] = $request->input('is_published', false);
            $testimonial->save();

            // Use the API helper for response
            return wt_api_json_success($testimonial, null, 'Testimonial created successfully');
        } catch (\Exception $e) {
            // Handle any exceptions that might occur
            return wt_api_json_error($e->getMessage(), 500, 'An error occurred while creating the testimonial');
        }
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