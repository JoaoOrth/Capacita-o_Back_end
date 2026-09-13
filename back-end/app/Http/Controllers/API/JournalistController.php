<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Journalist;
use App\Http\Requests\API\JournalistRequest;

class JournalistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $journalist = Journalist::all();
        return response()->json(['message' => 'success', 'data' => $journalist], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JournalistRequest $request)
    {
        $journalist = Journalist::create($request->all());
        $journalist->news()->attach($request->news_id);
        return response()->json(['message' => 'success', 'data' => $journalist], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $journalist = Journalist::find($id)->with('news')->get();
        if (!$journalist) {
            return response()->json(['message' => 'Journalist not found', 'data' => null], 404);
        }
        return response()->json(['message' => 'success', 'data' => $journalist], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JournalistRequest $request, string $id)
    {
        $journalist = Journalist::find($id);
        if (!$journalist) {
            return response()->json(['message' => 'Journalist not found', 'data' => null], 404);
        }
        $journalist->update($request->all());
        $journalist->news()->sync($request->news_id);
        return response()->json(['message' => 'success', 'data' => $journalist], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $journalist = Journalist::find($id);
        if (!$journalist) {
            return response()->json(['message' => 'Journalist not found', 'data' => null], 404);
        }
        $journalist->news()->detach();
        $journalist->delete();
        return response()->json(['message' => 'success', 'data' => null], 200);
    }
}
