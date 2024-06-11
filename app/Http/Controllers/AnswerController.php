<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $answers = Answer::all();
            return response()->json([
                'message' => 'Answers retrieved successfully',
                'data' => $answers,
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
            $answers = Answer::findOrFail($id);
            return response()->json([
                'message' => 'Answer retrieved successfully',
                'data' => $answers,
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
            'text' => 'required|String',
            'question_id' => 'required|exists:questions,id',
        ]);

        try {

            $answer = Answer::create($validatedData);
            return response()->json([
                'message' => 'Answer added successfully',
                'data' => $answer,
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
            'text' => 'required|String',
            'question_id' => 'required|exists:questions,id',
        ]);

        try {

            $answer = Answer::findOrFail($id);
            $answer->update($validatedData);

            return response()->json([
                'message' => 'Answer updated successfully',
                'data' => $answer,
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
            $answer = Answer::findOrFail($id);
            $answer->delete();

            return response()->json([
                'message' => 'Answer deleted successfully',
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

    public function getAnswersByQuestionId($id): JsonResponse
    {
        try {
            $answer = Answer::where('question_id', $id)->get();
            return response()->json([
                'message' => 'Questions retrieved successfully',
                'data' => $answer,
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


