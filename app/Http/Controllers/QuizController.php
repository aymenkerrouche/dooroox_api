<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $quizzes = Quiz::all();
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
            $quizz = Quiz::findOrFail($id);
            return response()->json([
                'message' => 'Quiz retrieved successfully',
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
            'content_id' => 'required',
        ]);

        try {

            $quizz = Quiz::create($validatedData);
            return response()->json([
                'message' => 'Quiz added successfully',
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
            'content_id' => 'required',
        ]);

        try {

            $quizz = Quiz::findOrFail($id);
            $quizz->update($validatedData);

            return response()->json([
                'message' => 'Quiz updated successfully',
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
            $quizz = Quiz::findOrFail($id);
            $quizz->delete();

            return response()->json([
                'message' => 'Quiz deleted successfully',
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

    public function getQuizByContentId($id): JsonResponse
    {
        try {
            $quizzes = Quiz::where('content_id', $id)->get();
            return response()->json([
                'message' => 'Quizzes retrieved successfully',
                'data' => $quizzes,
                'error' => null,
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

}
