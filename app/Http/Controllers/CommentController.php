<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(): JsonResponse
    {
        $comments = Comment::all();

        try {
            return response()->json([
                'message' => 'Comments retrieved successfully',
                'data' => $comments,
                'error' => null,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content_id' => 'required|exists:contents,id',
            'comment' => 'required|string',
        ]);
        $comment = Comment::create($request->all());

        try {

            return response()->json([
                'message' => 'Comment created successfully',
                'data' => $comment,
                'error' => null,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

        public function show($id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        try {
            return response()->json([
                'message' => 'Comment retrieved successfully',
                'data' => $comment,
                'error' => null,
            ]);
        }
        // a comment with a given ID doesn't exist
        catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Comment not found',
            ], 404);
        }
        // unexpected
        catch (Exception $e) {
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
            'user_id' => 'required|exists:users,id',
            'content_id' => 'required|exists:contents,id',
            'comment' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);
        $comment->update($request->all());

        try {


            return response()->json([
                'message' => 'Comment updated successfully',
                'data' => $comment,
                'error' => null,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Comment not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }

    }

    public function destroy($id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        try {

            return response()->json([
                'message' => 'Comment deleted successfully',
                'data' => null,
                'error' => null,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Comment not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
