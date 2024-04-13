<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfController extends Controller
{
    public function get_content(Request $request): JsonResponse
    {
        $profId = $request->input('prof_id');

        // Retrieve contents associated with the specified prof_id
        $contents = Content::where('prof_id', $profId)->get();

        return response()->json($contents);
    }

    public function add_content(Request $request): JsonResponse
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'cover_picture' => 'required|string',
            'total_rate' => 'required|numeric|min:0',
            'total_comment' => 'required|numeric|min:0',
            'content_type' => 'required|string',
            'tag' => 'required|string',
            'price' => 'required|numeric|min:0',
            'prof_id' => 'required|exists:prof,id',
        ]);

        $content = Content::create($request->all());

        return response()->json(['message' => 'Content added successfully', 'data' => $content], 201);
    }


    public function destroy_content($id): JsonResponse
    {
        $content = Content::find($id);

        if (!$content) {
            return response()->json(['error' => 'Content not found'], 404);
        }

        $content->delete();

        return response()->json(['message' => 'Content deleted successfully'], 200);
    }




    public function add_online_group(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        try {
            $onlineGroup = new OnlineGroup();
            $onlineGroup->name = $validatedData['name'];
            $onlineGroup->description = $validatedData['description'];

            $onlineGroup->save();

            return response()->json(['message' => 'Online group added successfully', 'data' => $onlineGroup], 201);
        } catch (\Exception $e) {

            return response()->json(['error' => 'Failed to add online group: ' . $e->getMessage()], 500);
        }
    }


    public function add_f2f_group() {
        //
    }
}
