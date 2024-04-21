<?php

namespace App\Http\Controllers;

use App\Models\Pdf_material;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Pdf_materialController extends Controller
{
    public function index(): JsonResponse
    {
        $pdfMaterials = Pdf_material::all();
        return response()->json(['data' => $pdfMaterials]);
    }

    public function show($id): JsonResponse
    {
        $pdfMaterial = Pdf_material::find($id);
        if (!$pdfMaterial) {
            return response()->json(['error' => 'PDF material not found'], 404);
        }
        return response()->json(['data' => $pdfMaterial]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'path' => 'required|string',
        ]);


            $pdfMaterial = Pdf_material::create($request->all());
            return response()->json(['message' => 'PDF material added successfully', 'data' => $pdfMaterial], 201);

    }

    public function update(Request $request, $id): JsonResponse
    {


        $request->validate([
            'name' => 'required|string',
            'path' => 'required|string',
        ]);

        $comment = Pdf_material::findOrFail($id);
        $comment->update($request->all());

       return response()->json(['message' => 'PDF material updated successfully', 'data' ,200]);

    }

    public function destroy($id): JsonResponse
    {
        $pdfMaterial = Pdf_material::find($id);



            $pdfMaterial->delete();
            return response()->json(['message' => 'PDF material deleted successfully']);

    }

}
