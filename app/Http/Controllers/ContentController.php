<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function getContent(Content $content)
    {
        //
    }

    public function deleteContent(Content $content)
    {
        //
    }

    public function addContent(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'cover_picture' => 'string',
            'total_rate' => 'numeric',
            'total_comment' => 'integer',
            'content_type' => 'integer',
            'tag' => 'string',
            'createdAt' => 'date',
            'updatedAt' => 'date',

        ]);

        $content = Content::create($request);
        $content->save();


        return response()->json(['message' => 'Content created successfully', 'content' => $content], 201);
    }


    public function editContent(Request $request, Content $content)
    {
        //
    }

    public function searchContent(Request $request)
    {
        //
    }
}
