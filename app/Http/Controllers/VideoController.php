<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function get_video($id): JsonResponse
    {
        try {
            $video = Video::findOrFail($id);
            return response()->json([
                'message' => 'Video retrieved successfully',
                'data' => $video,
                'error' => null], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage()], 500);
        }
    }

    public function upload_video(Request $request): JsonResponse
    {
        $request->validate(
            ['path' => 'required|string',
            'content_id' => 'required']
        );
        try {
            $video = Video::create($request->all());

            return response()->json([
                'message' => 'Video uploaded successfully',
                'data' => $video,
                'error' => null], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
               ' data' => null,
                'error' => $e->getMessage()], 500);
        }

    }

    public function update_path($id ,Request $request): JsonResponse
    {
        $request->validate(
            ['path' => 'required|string',
                'content_id' => 'required']
        );

        try {

            $video = Video::findOrFail($id);
            $video->path = $request->path;
            $video->save();

            return response()->json([
                'message' => 'Video path updated successfully',
                'data' => $video,
                'error' => null], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage()], 500);
        }
        }

    public function delete_video($id): JsonResponse
    {
        $id->validate([
            'id' => 'required|exists:videos,id',
        ]);

        try {
            $video = Video::findOrFail($id);
            $video->delete();

            return response()->json(['message' => 'Video deleted successfully', 'error' => null], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => null, 'error' => $e->getMessage()], 404);
        }
    }
}
