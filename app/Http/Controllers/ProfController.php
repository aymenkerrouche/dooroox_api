<?php

namespace App\Http\Controllers;

use App\Models\Prof;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
//update_me
//best_teacher = function )migration) user_id / prof_id / order (integer) create 5 profs
//new migration = major (id - name - foreigh key men level -specilaty) copier coller mn user / picture
class ProfController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $profs = Prof::all();
            return response()->json([
                'message' => 'Professors retrieved successfully',
                'data' => $profs,
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
            $prof = Prof::where('user_id', $id)->firstOrFail();
            return response()->json([
                'message' => 'Professor retrieved successfully',
                'data' => $prof,
                'error' => null,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Professor not found',
            ], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'phone' => 'required|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {

            $prof = Prof::create($request->all());
            return response()->json([
                'message' => 'Professor added successfully',
                'data' => $prof,
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
        $request->validate([
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        try {

            $prof = Prof::where('user_id', $id)->firstOrFail();
            $prof->update($request->all());

            return response()->json([
                'message' => 'Professor updated successfully',
                'data' => $prof,
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

    public function update_me(Request $request): JsonResponse
    {

        try {
            $user = auth()->user();
            $prof = Prof::where('user_id', $user->id)->firstOrFail();

            if ($request->has('phone')) {
                $request->validate([
                    'phone' => 'nullable|string',
                ]);
                $prof->phone = $request->phone;
            }

            if ($request->has('location')) {
                $request->validate([
                    'location' => 'nullable|string',
                ]);
                $prof->sex = $request->location;
            }

            if ($request->has('latitude')) {
                $request->validate([
                    'phone' => 'nullable|string',
                ]);
                $prof->phone = $request->latitude;
            }

            if ($request->has('longitude')) {
                $request->validate([
                    'district' => 'nullable|string',
                ]);
                $prof->longitude = $request->longitude;
            }




            $prof->save();

            return response()->json([
                "message" => "Prof profile updated successfully",
                "data" => $prof,
                "error" => null
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $prof = Prof::where('user_id', $id)->firstOrFail();
            $prof->delete();
            return response()->json([
                'message' => 'Professor deleted successfully',
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
    }

//    public function addSchool(Request $request, $id): JsonResponse
//    {
//        $request->validate([
//            'school_id' => 'required|exists:schools,id',
//        ]);
//
//        $prof = Prof::where('user_id', $id)->firstOrFail();
//        $school = School::findOrFail($request->input('school_id'));
//
//        $prof->schools()->attach($school);
//
//        return response()->json(['message' => 'School associated with Prof successfully'], 200);
//    }

//    public function addContent(Request $request, $id): JsonResponse
//    {
//        $request->validate([
//            'title' => 'required|string',
//            'body' => 'required|string',
//        ]);
//
//        $prof = Prof::where('user_id', $id)->firstOrFail();
//
//        $content = new Content($request->all());
//        $prof->contents()->save($content);
//
//        return response()->json(['message' => 'Content added successfully'], 200);
//    }

//    public function changeStatus(Request $request, $id): JsonResponse
//    {
//        $request->validate([
//            'status' => 'required|in:active,inactive',
//        ]);
//
//        $prof = Prof::where('user_id', $id)->firstOrFail();
//        $prof->update(['status' => $request->input('status')]);
//
//        return response()->json(['message' => 'Prof status changed successfully'], 200);
//    }
//}
