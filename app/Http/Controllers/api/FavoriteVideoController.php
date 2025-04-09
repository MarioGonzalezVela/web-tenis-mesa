<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FavoriteVideo;

class FavoriteVideoController extends Controller
{

    protected $favoriteVideo;

    public function __construct(FavoriteVideo $favoriteVideo)
    {
        $this->favoriteVideo = $favoriteVideo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favoriteVideos = $this->favoriteVideo->with(['customer', 'video'])->get();
        return response()->json($favoriteVideos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'video_id' => 'required|exists:videos,id',
        ]);

        $favoriteVideo = $this->favoriteVideo->create($data);
        return response()->json([
            'message' => 'Vídeo agregado a favoritos.',
            'data' => $favoriteVideo->load(['customer', 'video'])
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $favoriteVideo = $this->favoriteVideo->with(['customer', 'video'])->findOrFail($id);
        return response()->json($favoriteVideo, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'video_id' => 'required|exists:videos,id',
        ]);

        $favoriteVideo = $this->favoriteVideo->findOrFail($id);
        $favoriteVideo->update($data);
        return response()->json($favoriteVideo, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $favoriteVideo = $this->favoriteVideo->findOrFail($id);
        $favoriteVideo->delete();
        return response()->json(['message' => 'Vídeo eliminado de favoritos'], 200);
    }
}
