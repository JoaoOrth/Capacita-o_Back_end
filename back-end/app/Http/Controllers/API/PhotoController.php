<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Photo;
use App\Http\Requests\API\PhotoRequest;
use Storage;
use App\Models\News;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $photo = Photo::all();
        return response()->json(['message' => 'success', 'data' => $photo], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhotoRequest $request)
    {
        if(!$request->image){
            return response()->json(['message' => 'Imagem necessária', 'data' => null], 400);
        }
        $file_path = $request->file('image')->store('photos');

        $photo = Photo::create([
            'local' => $request->local,
            'description' => $request->description,
            'image' => $file_path,
            'placeholder' => $request->placeholder,
            'news_id' => $request->news_id
        ]);
        return response()->json(['message' => 'success', 'data' => $photo], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $photo = Photo::find($id);

        if (!$photo) {
            return response()->json(['message' => 'Foto não encontrada', 'data' => null], 404);
        }

        return response()->json(['message' => 'success', 'data' => $photo], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PhotoRequest $request, string $id)
    {
        $photo = Photo::find($id);

        if (!$photo) {
            return response()->json(['message' => 'Foto não encontrada', 'data' => null], 404);
        }

        $file_path = NULL;
        
        if ($request->hasFile('image')) {
            if(Storage::exists($photo->image)){
                Storage::delete($photo->image);
            }
            $file_path = $request->file('image')->store('photos');
        }

        $photo->update([
            'local' => $request->local,
            'description' => $request->description,
            'image' => $request->file('image') ? $file_path : $photo->image,
            'placeholder' => $request->placeholder,
            'news_id' => $request->news_id
        ]);
        return response()->json(['message' => 'Foto atualizada', 'data' => $photo], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $photo = Photo::find($id);
        if (!$photo) {
            return response()->json(['message' => 'Foto não encontrada', 'data' => null], 404);
        }
        if(Storage::delete($photo->image)){
            Storage::delete($photo->image);
        }
        
        $photo->delete();
        return response()->json(['message' => 'Foto deletada', 'data' => null], 200);
    }
}
