<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(): JsonResponse
    {

        try {
            $contents = Content::all();
            return response()->json([
                'message' => 'Contents retrieved successfully',
                'data' => $contents,
                'error' => null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }    }


    public function show($id): JsonResponse
    {

        try {
            $content = Content::findOrFail($id);
            return response()->json([
                'message' => 'Content retrieved successfully',
                'data' => $content,
                'error' => null,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }    }


    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'creator_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'description' => 'required',
            'cover_picture' => 'nullable|string',
            'total_rate' => 'nullable|numeric',
            'total_comment' => 'nullable|integer',
            'content_type' => 'required|string',
            'tag' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        try {

            $content = Content::create($request->all());
            return response()->json([
                'message' => 'Content created successfully',
                'data' => $content,
                'error' => null,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'cover_picture' => 'nullable|string',
            'total_rate' => 'nullable|numeric',
            'total_comment' => 'nullable|integer',
            'content_type' => 'required|string',
            'tag' => 'nullable|string',
            'price' => 'nullable|numeric',
        ]);

        try {

            $content = Content::findOrFail($id);
            $content->update($request->all());
            return response()->json([
                'message' => 'Content updated successfully',
                'data' => $content,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function search(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'keywords' => 'required|string',
            ]);
            $keywords = explode(' ', $request->input('keywords'));
            $query = Content::query();
            foreach ($keywords as $keyword) {
                $query->where(function ($query) use ($keyword) {
                    $query->where('title', 'like', "%{$keyword}%")
                        ->orWhere('description', 'like', "%{$keyword}%")
                        ->orWhere('content_type', 'like', "%{$keyword}%")
                        ->orWhere('tag', 'like', "%{$keyword}%")
                        ->orWhere('price', 'like', "%{$keyword}%");
                });
            }
            $contents = $query->get();
            return response()->json([
                'message' => 'Search results retrieved successfully',
                'data' => $contents,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function getTeacherContents($creatorId): JsonResponse
    {
        try {
            $contents = Content::where('creator_id', $creatorId)->get();
            return response()->json([
                'message' => 'Teacher contents retrieved successfully',
                'data' => $contents,
                'error' => null,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }}


    public function destroy($id): JsonResponse
    {
        try {
            $content = Content::findOrFail($id);
            $content->delete();
            return response()->json([
                'message' => 'Content deleted successfully',
                'data' => null,
                'error' => null,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
