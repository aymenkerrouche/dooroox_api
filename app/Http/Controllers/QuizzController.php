<?php

namespace App\Http\Controllers;

use http\Message\Body;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    public function index(): JsonResponse
    {
        $quizzes = Quizz::all();
        return response()->json($quizzes);
    }

    public function show($id): JsonResponse
    {
        $quizz = Quizz::findOrFail($id);
        return response()->json($quizz);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $quizz = Quizz::create($validatedData);
        return response()->json(['message' => 'Quizz added successfully'], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $quizz = Quizz::findOrFail($id);
        $quizz->update($validatedData);

        return response()->json(['message' => 'Quizz updated successfully'], 200);
    }

    public function destroy($id): JsonResponse
    {
        $quizz = Quizz::findOrFail($id);
        $quizz->delete();

        return response()->json(['message' => 'Quizz deleted successfully'], 200);
    }

}
