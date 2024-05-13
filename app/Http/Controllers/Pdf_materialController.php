<?php

namespace App\Http\Controllers;

use App\Models\Pdf_material;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Pdf_materialController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $pdfMaterials = Pdf_material::all();
            return response()->json([
                'message' => 'PDF materials retrieved successfully',
                'data' => $pdfMaterials,
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

    public function show($id): JsonResponse
    {
        try {
            $pdfMaterial = Pdf_material::find($id);
            if (!$pdfMaterial) {
                return response()->json([
                    'message' => null,
                    'data' => null,
                    'error' => 'PDF material not found'
                ], 404);
            }
            return response()->json([
                'message' => 'PDF material retrieved successfully',
                'data' => $pdfMaterial,
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

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string',
            'path' => 'required|string',
        ]);

        try {
        $request->validate([
            'name' => 'required|string',
            'path' => 'required|string',
        ]);

        $pdfMaterial = Pdf_material::create($request->all());
        return response()->json([
            'message' => 'PDF material added successfully',
            'data' => $pdfMaterial,
            'error' => null,
        ], 201);
    } catch (\Exception $e) {
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
            'name' => 'required|string',
            'path' => 'required|string',
        ]);

        try {

            $pdfMaterial = Pdf_material::findOrFail($id);
            $pdfMaterial->update($request->all());

            return response()->json([
                'message' => 'PDF material updated successfully',
                'data' => $pdfMaterial,
                'error' => null,
            ], 200);
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
            $pdfMaterial = Pdf_material::find($id);
            if (!$pdfMaterial) {
                return response()->json([
                    'message' => null,
                    'data' => null,
                    'error' => 'PDF material not found'
                ], 404);
            }

            $pdfMaterial->delete();
            return response()->json([
                'message' => 'PDF material deleted successfully',
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

}
