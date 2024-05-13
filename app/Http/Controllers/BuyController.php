<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    public function index(): JsonResponse
    {
        $buys = Buy::all();
        try {
            return response()->json([
                'message' => 'Buys retrieved successfully',
                'data' => $buys,
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

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'book_id' => 'required|exists:books,id',
            'ref' => 'required|string',
        ]);

        $buy = Buy::create($request->all());

        try {

            return response()->json([
                'message' => 'Buy created successfully',
                'data' => $buy,
                'error' => null,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'error',
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }    }

    public function show($id): JsonResponse
    {
        $buy = Buy::findOrFail($id);
        try {
            return response()->json([
                'message' => 'Buy retrieved successfully',
                'data' => $buy,
                'error' => null,
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Buy not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'book_id' => 'required|exists:books,id',
            'ref' => 'required|string',
        ]);


        try {

            $buy = Buy::findOrFail($id);
            $buy->update($request->all());

            return response()->json([
                'message' => 'Buy updated successfully',
                'data' => $buy,
                'error' => null,
            ], 200);
        }

        catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Buy not found',
            ], 404);
        }

        catch (Exception $e) {
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
            $buy = Buy::findOrFail($id);
            $buy->delete();
            return response()->json([
                'message' => 'Buy deleted successfully',
                'data' => null,
                'error' => null,
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'Buy not found',
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
