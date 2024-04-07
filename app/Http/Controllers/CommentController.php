<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(): JsonResponse
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content_id' => 'required|exists:contents,id',
            'comment' => 'required|string',
        ]);

        $comment = Comment::create($request->all());

        return response()->json($comment, 201);
    }

    public function show($id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        return response()->json($comment);
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

        return response()->json($comment, 200);
    }

    public function destroy($id): JsonResponse
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
