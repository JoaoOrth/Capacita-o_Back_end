<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\News;
use App\Http\Requests\API\NewsRequest;
use App\Models\Journalist;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::all();
        
        return response()->json(['message' => 'success', 'data' => $news], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsRequest $request)
    {
        if(!$request->journalist_id){
            return response()->json(['message' => 'Jornalista não encontrado'],404);
        }
        foreach($request->journalist_id as $journalist_id){
            if(!Journalist::find($journalist_id)){
                return response()->json(['message' => 'Jornalista não encontrado'],404);
            }
        }   
        $news = News::create($request->all());
        $news->journalists()->attach($request->journalist_id);

        return response()->json(['message' => 'success', 'data' => $news], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $news = News::find($id)->with(['journalists', 'photos'])->get();


        if (!$news) {
            return response()->json(['message' => 'News not found', 'data' => null], 404);
        }

        return response()->json(['message' => 'success', 'data' => $news], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsRequest $request, string $id)
    {
        
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found', 'data' => null], 404);
        }
        if(!$request->journalist_id){
            return response()->json(['message' => 'Jornalista não encontrado'],404);
        }
        foreach($request->journalist_id as $journalist_id){
            if(!Journalist::find($journalist_id)){
                return response()->json(['message' => 'Jornalista não encontrado'],404);
            }
        }   

        $news->update($request->all());
        $news->journalist()->sync($request->journalist_id);
        return response()->json(['message' => 'success', 'data' => $news], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::find($id);

        if (!$news) {
            return response()->json(['message' => 'News not found', 'data' => null], 404);
        }
        if($news->photos->isNotEmpty()){
            return response()->json(['message' => 'Não é possível deletar uma notícia que possui fotos associadas', 'data' => null], 400);
        }
        $news->journalist()->detach();
        $news = News::destroy($id);

        return response()->json(['message' => 'success', 'data' => null], 200);
    }
}
