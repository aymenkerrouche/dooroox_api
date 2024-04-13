<?php

namespace App\Http\Controllers;

use App\Models\Level;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(): JsonResponse
    {
        $levels = Level::all();
        return response()->json($levels);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'grade' => 'required',
            'year' => 'required',
        ]);

        $level = Level::create($request->all());

        return response()->json(['message' => 'Level added successfully'], 201);
    }

    public function show($id): JsonResponse
    {
        $level = Level::findOrFail($id);
        return response()->json($level);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'grade' => 'required',
            'year' => 'required',
        ]);

        $level = Level::findOrFail($id);
        $level->update($request->all());

        return response()->json(['message' => 'Level updated successfully'], 200);
    }

    public function destroy($id): JsonResponse
    {
        $level = Level::findOrFail($id);
        $level->delete();

        return response()->json(['message' => 'Level deleted successfully'], 200);
    }
}
