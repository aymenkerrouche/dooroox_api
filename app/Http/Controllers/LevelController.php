<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function get_levels()
    {
        $levels = Level::all();
        return response()->json(['data' => $levels]);
    }

    public function add_level(Request $request)
    {

        $validatedData = $request->validate([
            'grade' => 'required',
            'year' => 'required',
        ]);

        $level = Level::create($validatedData);
        return response()->json(['message' => 'Level added successfully', 'data' => $level], 201);
    }


    public function update_level(Request $request, $id): JsonResponse
    {
        $request->validate([
            'grade' => 'required',
            'year' => 'required',
        ]);

        $level = Level::findOrFail($id);
        $level->update($request->all());
        return response()->json(['message' => 'Level updated successfully', 'data' => $level]);
    }


    public function delete_level($id)
    {
        $level = Level::findOrFail($id);
        $level->delete();
        return response()->json(['message' => 'Level deleted successfully']);
    }




}
