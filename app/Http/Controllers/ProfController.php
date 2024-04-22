<?php

namespace App\Http\Controllers;

use App\Models\Prof;
//use App\Models\School;
//use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfController extends Controller
{

    public function index(): JsonResponse
    {
        $profs = Prof::all();
        return response()->json($profs);
    }

    public function show($id): JsonResponse
    {
        $prof = Prof::where('user_id', $id)->firstOrFail();
        return response()->json($prof);
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

        $prof = Prof::create($request->all());
        return response()->json($prof, 201);
    }


    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'phone' => 'nullable|string',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $prof = Prof::where('user_id', $id)->firstOrFail();
        $prof->update($request->all());
        return response()->json($prof, 200);
    }

    public function destroy($id): JsonResponse
    {
        $prof = Prof::where('user_id', $id)->firstOrFail();
        $prof->delete();
        return response()->json(['message' => 'Prof deleted successfully'], 200);
    }}

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
