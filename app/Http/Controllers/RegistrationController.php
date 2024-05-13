<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Registration;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{

    public function registerStudent(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'wallet_id' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        try {
            // Begin a database transaction
            DB::beginTransaction();

            $studentId = auth()->id();

            $content = Content::findOrFail($validatedData['content_id']);

            $content->students()->attach($studentId);

            Registration::create([
                'wallet_id' => $validatedData['wallet_id'],
                'content_id' => $validatedData['content_id'],
                'amount' => $validatedData['amount'],
            ]);


            DB::commit();

            return response()->json([
                'message' => 'Student enrolled successfully',
                'data' => null,
                'error' => null,
            ]);

        } catch (Exception $e) {

            DB::rollback();
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Failed to enroll student: ' . $e->getMessage(),
            ], 500);
        }
    }




    public function getRegistrationById($id): JsonResponse
    {
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Registration not found',
            ], 404);        }

        return response()->json([
            'message' => 'Registration retrieved successfully',
            'data' => $registration,
            'error' => null,
        ]);    }

    public function getAllRegistrations(): JsonResponse
    {
        $registrations = Registration::all();

        return response()->json([
            'message' => 'All registrations retrieved successfully',
            'data' => $registrations,
            'error' => null,
        ]);
    }



    public function getRegistrationByContentIdOrUserId(Request $request): JsonResponse
    {
        $contentId = $request->input('content_id');
        $userId = $request->input('user_id');

        if ($contentId) {
            $registrations = Registration::where('content_id', $contentId)->get();
        } elseif ($userId) {
            $registrations = Registration::where('user_id', $userId)->get();
        } else {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Missing content_id or user_id parameter',
            ], 400);        }

        return response()->json([
            'message' => 'Registrations retrieved successfully',
            'data' => $registrations,
            'error' => null,
        ]);    }


    public function cancelRegistration($id): JsonResponse
    {
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Registration not found',
            ], 404);        }

        $registration->delete();

        return response()->json([
            'message' => 'Registration cancelled successfully',
            'data' => null,
            'error' => null,
        ]);    }

    public function updateRegistration($id, Request $request): JsonResponse
    {
        $registration = Registration::find($id);

        if (!$registration) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Registration not found',
            ], 404);        }

        $validatedData = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $registration->update([
            'amount' => $validatedData['amount'],
        ]);

        return response()->json([
            'message' => 'Registration updated successfully',
            'data' => null,
            'error' => null,
        ]);    }
}
