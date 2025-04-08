<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Video;

class VideoController extends Controller

{
    protected $video;

    public function __construct(Video $video)
    {
        $this->video = $video;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = $this->video->all();
        return response()->json($videos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'description' => 'required|string|min:10',
            'difficulty' => 'required|in:Principiante,Intermedio,Experto'
        ]);

        $video = $this->video->create($data);
        return response()->json($video, 201);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $video = $this->video->findOrFail($id);
        return response()->json($video, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'required|url',
            'description' => 'required|string|min:10',
            'difficulty' => 'required|in:Principiante,Intermedio,Experto'
        ]);

        $video = $this->video->findOrFail($id);
        $video->update($data);
        return response()->json($video, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $video = $this->video->findOrFail($id);
        $video->delete();
        return response()->json(null, 204);
    }
}
