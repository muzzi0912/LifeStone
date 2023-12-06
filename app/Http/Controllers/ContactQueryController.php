<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactQueryRequest;
use Illuminate\Http\Request;
use App\Models\ContactQuery;

class ContactQueryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve all contact queries from the database
        $contactQueries = ContactQuery::all();

        // Use the API helper for response
        return wt_api_json_success($contactQueries, null, 'Contact queries retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactQueryRequest $request)
    {
        // Create a new contact query
        $contactQuery = ContactQuery::create($request->validated());

        // Use the API helper for response
        return wt_api_json_success($contactQuery, null, 'Contact query created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contactQuery = ContactQuery::find($id);

        if (!$contactQuery) {
            return wt_api_json_error('Contact query not found', 404);
        }

        return wt_api_json_success($contactQuery, null, 'Contact query retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Placeholder for update method
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Placeholder for destroy method
    }
}
