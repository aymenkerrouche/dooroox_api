<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $specialities = Speciality::all();
            return response()->json([
                "message" => "Specialities retrieved successfully",
                "data" => $specialities,
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

    public function show($id): JsonResponse
    {
        try {
            $speciality = Speciality::findOrFail($id);
            return response()->json([
                "message" => "Speciality retrieved successfully",
                "data" => $speciality,
                "error" => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "message" => null,
                "data" => null,
                "error" => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        try {

            $speciality = Speciality::create($validatedData);
            return response()->json([
                "message" => "Speciality created successfully",
                "data" => $speciality,
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
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        try {

            $speciality = Speciality::findOrFail($id);
            $speciality->update($validatedData);

            return response()->json([
                "message" => "Speciality updated successfully",
                "data" => $speciality,
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

    public function destroy($id): JsonResponse
    {
        try {
            $speciality = Speciality::findOrFail($id);
            $speciality->delete();

            return response()->json([
                "message" => "Speciality deleted successfully",
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

}
