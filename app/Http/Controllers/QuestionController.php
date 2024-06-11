<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $questions = Question::all();
            return response()->json([
                'message' => 'Questions retrieved successfully',
                'data' => $questions,
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
            $question = Question::findOrFail($id);
            return response()->json([
                'message' => 'Question retrieved successfully',
                'data' => $question,
                'error' => null,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' =>  $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'text' => 'required',
            'quiz_id' => 'required',
        ]);

        try {

            $question = Question::create($validatedData);
            return response()->json([
                'message' => 'Question added successfully',
                'data' => $question,
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
            'text' => 'required',
            'quiz_id' => 'required',
        ]);

        try {

            $question = Question::findOrFail($id);
            $question->update($validatedData);

            return response()->json([
                'message' => 'Question updated successfully',
                'data' => $question,
                'error' => null,
            ]);
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
            $question = Question::findOrFail($id);
            $question->delete();

            return response()->json([
                'message' => 'Question deleted successfully',
                'data' => null,
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

    public function getQestionsByQuizId($id): JsonResponse
    {
        try {
            $questions = Question::where('quiz_id', $id)->get();
            return response()->json([
                'message' => 'Questions retrieved successfully',
                'data' => $questions,
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

}


