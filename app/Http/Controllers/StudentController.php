<?php

namespace App\Http\Controllers;

use App\Models\Level;
use App\Models\Speciality;
use App\Models\Student;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $students = Student::all();
            return response()->json([
                "message" => "Students retrieved successfully",
                "data" => $students,
                "error" => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $student = Student::where('user_id', $id)->firstOrFail();
            return response()->json([
                "message" => "Student retrieved successfully",
                "data" => $student,
                "error" => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'wilaya' => 'nullable|string',
            'sex' => 'nullable|string',
            'phone' => 'nullable|string',
            'district' => 'nullable|string',
            'birthday' => 'nullable|date',
            'level_id' => 'nullable|exists:levels,id',
        ]);
        try {


            $student = Student::create($request->all());
            return response()->json([
                "message" => "Student created successfully",
                "data" => $student,
                "error" => null
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }
    }


    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'wilaya' => 'nullable|string',
            'sex' => 'nullable|string',
            'phone' => 'nullable|string',
            'district' => 'nullable|string',
            'birthday' => 'nullable|date',
            'level_id' => 'nullable|exists:levels,id',
            'speciality_id' => 'nullable|exists:specialities,id',
        ]);



        try {

            $student = Student::where('user_id', $id)->firstOrFail();
            $student->update($request->all());

            return response()->json([
                "message" => "Profile updated successfully",
                "data" => $student,
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
            $student = Student::where('user_id', $id)->firstOrFail();
            $student->delete();

            return response()->json([
                "message" => "Student deleted successfully",
                "data" => null,
                "error" => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }   }

    public function search(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'query' => 'required|string',
            ]);

            $query = $request->input('query');

            $students = Student::where('wilaya', 'like', "%$query%")
                ->orWhere('district', 'like', "%$query%")
                ->orWhere('birthday', 'like', "%$query%")
                ->orWhere('level_id', 'like', "%$query%")
                ->get();

            return response()->json([
                "message" => "Students retrieved successfully",
                "data" => $students,
                "error" => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function changeStatus(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'required|in:active,inactive',
            ]);

            $student = Student::where('user_id', $id)->firstOrFail();
            $student->update(['status' => $request->input('status')]);

            return response()->json([
                "message" => "Student status changed successfully",
                "data" => null,
                "error" => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }
      }


    public function addSpeciality(Request $request, $id): JsonResponse
    {
        try {
            $request->validate([
                'speciality_id' => 'required|exists:specialities,id',
            ]);

            $student = Student::where('user_id', $id)->firstOrFail();
            $speciality = Speciality::findOrFail($request->input('speciality_id'));

            // Associate the speciality with the student
            $student->speciality()->associate($speciality);
            $student->save();

            return response()->json([
                "message" => "Speciality added to student successfully",
                "data" => null,
                "error" => null
            ]);
        } catch (Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }
    }

    public function changeLevel(Request $request, $id): JsonResponse
    {
        $request->validate([
            'level_id' => 'required|exists:levels,id',
        ]);

        try {


            $student = Student::where('user_id', $id)->firstOrFail();
            $level = Level::findOrFail($request->input('level_id'));

            // Associate the level with the student
            $student->level()->associate($level);
            $student->save();

            return response()->json([
                "message" => "Student level changed successfully",
                "data" => null,
                "error" => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 500);
        }
    }




}
