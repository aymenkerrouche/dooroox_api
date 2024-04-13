<?php

namespace App\Http\Controllers;

use App\Models\Buy;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyController extends Controller
{
    public function index(): JsonResponse
    {
        $buys = Buy::all();
        return response()->json($buys);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'book_id' => 'required|exists:books,id',
            'ref' => 'required|string',
        ]);

        $buy = Buy::create($request->all());

        return response()->json($buy, 201);
    }

    public function show($id): JsonResponse
    {
        $buy = Buy::findOrFail($id);
        return response()->json($buy);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'wallet_id' => 'required|exists:wallets,id',
            'book_id' => 'required|exists:books,id',
            'ref' => 'required|string',
        ]);

        $buy = Buy::findOrFail($id);
        $buy->update($request->all());

        return response()->json($buy, 200);
    }

    public function destroy($id): JsonResponse
    {
        $buy = Buy::findOrFail($id);
        $buy->delete();

        return response()->json($buy, 200);
    }
}
