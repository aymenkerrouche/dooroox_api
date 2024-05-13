<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class WalletController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $wallets = Wallet::all();
            return response()->json([
                'message' => 'wallet retrieved successfully',
                'data' => $wallets,
                'error' => null], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'An error occurred while processing the request.', ], 500);

        }
    }

    public function show($id): JsonResponse
    {
        try {
            $wallet = Wallet::findOrFail($id);
            return response()->json([
                'message' => 'wallet retrieved successfully',
                'data' => $wallet,
                'error' => null], 200);        }

        catch (Exception $e) {
                return response()->json([
                    'message' => null,
                    'data' => null,
                    'error' => 'Content not found',
                ], 404);            }        }


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
            return response()->json([
                'message' => 'wallet created successfully',
                'data' => $wallet,
                'error' => null,
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => 'error'.$e->getMessage()], 500);
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

            if ($request->has('rib')) {
                $request->validate([
                    'rib' => 'sometimes|required',
                ]);
                $wallet->rib = $request->rib;
            }
            if ($request->has('balance')) {
                $wallet->rib = $request->balance;
            }
            if ($request->has('status')) {
                $wallet->rib = $request->status;
            }

            $wallet->save();

            return response()->json(['message' => 'Wallet updated successfully', 'data' => $wallet], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => 'validation error'.$e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => 'error'.$e->getMessage()], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $wallet = Wallet::findOrFail($id);
            $wallet->delete();

            return response()->json(['message' => 'Wallet deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'error'.$e->getMessage()], 500);
        }
    }


    public function incrementBalance(Request $request): JsonResponse
    {
        try {

            $user = auth()->user();
            $wallet = Wallet::where('user_id', $user->id)->firstOrFail();

            $request->validate([
                'amount' => 'required|min:0',
            ]);

            $wallet->balance += $request->amount;
            $wallet->save();

            return response()->json(['message' => 'Balance incremented successfully'], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function subtractBalance(Request $request): JsonResponse
    {
        try {
            $user = auth()->user();
            $wallet = Wallet::where('user_id', $user->id)->firstOrFail();


            $request->validate([
                'amount' => 'required|min:0',
            ]);

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

