<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestimonialRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'testimonial' => 'required',
            'client_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'client_name' => 'required',
            'client_designation' => 'required',
            'client_company' => 'required',
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
            'twitter_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv', // Adjust the mime types as needed
        ];
    }
}