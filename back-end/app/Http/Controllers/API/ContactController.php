<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Http\Requests\API\ContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact = Contact::all();

        return response()->json(['message' => 'success', 'data' => $contact], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ContactRequest $request)
    {
        $contact = Contact::create($request->all());

        return response()->json(['message' => 'success', 'data' => $contact], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found', 'data' => null], 404);
        }
        
        return response()->json(['message' => 'success', 'data' => $contact], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ContactRequest $request, string $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found', 'data' => null], 404);
        }

        $contact->update($request->all());

        return response()->json(['message' => 'success', 'data' => $contact], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found', 'data' => null], 404);
        }

        $contact = Contact::destroy($id);
        
        return response()->json(['message' => 'success', 'data' => null], 200);
    }
}
