<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function get_video($id): JsonResponse
    {
        $video = Video::findOrFail($id);
        return response()->json(['data' => $video]);
    }

    public function upload_video(Request $request): JsonResponse
    {
    $request->validate([
            'path' => 'required|string',
        ]);

        $video = Video::create([
            'path' => $request->path,
        ]);

        return response()->json(['message' => 'Video uploaded successfully', 'data' => $video], 201);
    }

    public function update_path($id ,Request $request): JsonResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $video = Video::findOrFail($id);
        $video->path = $request->path;
        $video->save();

        return response()->json(['message' => 'Video path updated successfully', 'data' => $video], 200);
    }

    public function delete_video(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required|exists:videos,id',
        ]);

        $video = Video::findOrFail($request->id);
        $video->delete();

        return response()->json(['message' => 'Video deleted successfully'], 200);
    }

}
