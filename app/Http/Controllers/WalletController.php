<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $wallets = Wallet::all();
            return response()->json($wallets, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $wallet = Wallet::findOrFail($id);
            return response()->json($wallet, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'rib' => 'required|unique:wallets,rib',
                'balance' => 'nullable|numeric',
                'status' => 'nullable|in:active,inactive',
            ]);

            $wallet = Wallet::create($request->all());

            return response()->json($wallet, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update($id, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'sometimes|exists:users,id',
                'rib' => 'sometimes|unique:wallets,rib,' . $id,
                'balance' => 'sometimes|numeric',
                'status' => 'sometimes|in:active,inactive',
            ]);

            $wallet = Wallet::findOrFail($id);
            $wallet->update($request->all());

            return response()->json(['message' => 'Wallet updated successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $wallet = Wallet::findOrFail($id);
            $wallet->delete();

            return response()->json(['message' => 'Wallet deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function incrementBalance($id, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0',
            ]);

            $wallet = Wallet::findOrFail($id);
            $wallet->balance += $request->amount;
            $wallet->save();

            return response()->json(['message' => 'Balance incremented successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function subtractBalance($id, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'amount' => 'required|numeric|min:0',
            ]);

            $wallet = Wallet::findOrFail($id);

            if ($wallet->balance < $request->amount) {
                throw new \Exception('Insufficient balance');
            }

            $wallet->balance -= $request->amount;
            $wallet->save();

            return response()->json(['message' => 'Balance subtracted successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}

