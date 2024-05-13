<?php

namespace App\Http\Controllers;

use App\Models\Quizz;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizzController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $quizzes = Quizz::all();
            return response()->json([
                'message' => 'Quizzes retrieved successfully',
                'data' => $quizzes,
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

    public function show($id): JsonResponse
    {
        try {
            $quizz = Quizz::findOrFail($id);
            return response()->json([
                'message' => 'Quizz retrieved successfully',
                'data' => $quizz,
                'error' => null,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' =>  $e->getMessage(),
            ], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        try {

            $quizz = Quizz::create($validatedData);
            return response()->json([
                'message' => 'Quizz added successfully',
                'data' => $quizz,
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

    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        try {

            $quizz = Quizz::findOrFail($id);
            $quizz->update($validatedData);

            return response()->json([
                'message' => 'Quizz updated successfully',
                'data' => $quizz,
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

    public function destroy($id): JsonResponse
    {
        try {
            $quizz = Quizz::findOrFail($id);
            $quizz->delete();

            return response()->json([
                'message' => 'Quizz deleted successfully',
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

    }}
