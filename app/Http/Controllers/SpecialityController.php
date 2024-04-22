<?php

namespace App\Http\Controllers;

use App\Models\Speciality;
use Illuminate\Http\Request;

class SpecialityController extends Controller
{
    public function index()
    {
        $specialities = Speciality::all();
        return response()->json(['data' => $specialities]);
    }

    public function show($id)
    {
        $speciality = Speciality::findOrFail($id);
        return response()->json(['data' => $speciality]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $speciality = Speciality::create($validatedData);
        return response()->json(['message' => 'Speciality created successfully', 'data' => $speciality], 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
        ]);

        $speciality = Speciality::findOrFail($id);
        $speciality->update($validatedData);

        return response()->json(['message' => 'Speciality updated successfully', 'data' => $speciality]);
    }

    public function destroy($id)
    {
        $speciality = Speciality::findOrFail($id);
        $speciality->delete();

        return response()->json(['message' => 'Speciality deleted successfully']);
    }

}
