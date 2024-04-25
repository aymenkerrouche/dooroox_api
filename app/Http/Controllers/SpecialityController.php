<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index(): JsonResponse
    {
        $specialities = Speciality::all();
        return response()->json($specialities);
    }

    public function show($id): JsonResponse
    {
        $speciality = Speciality::findOrFail($id);
        return response()->json(['data' => $speciality]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $speciality = Speciality::create($validatedData);
        return response()->json(['message' => 'Speciality created successfully', 'data' => $speciality], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $speciality = Speciality::findOrFail($id);
        $speciality->update($validatedData);

        return response()->json(['message' => 'Speciality updated successfully', 'data' => $speciality]);
    }

    public function destroy($id): JsonResponse
    {
        $speciality = Speciality::findOrFail($id);
        $speciality->delete();

        return response()->json(['message' => 'Speciality deleted successfully']);
    }

}
