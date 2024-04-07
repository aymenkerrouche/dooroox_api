<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'wallet_id' => 'required|exists:wallets,id',
            'amount' => 'required|numeric',
            'source' => 'required|string',
            'note' => 'nullable|string',
            'ref' => 'required|integer',
        ]);

        try {
            $transaction = Transaction::create([
                'user_id' => $request->user_id,
                'wallet_id' => $request->wallet_id,
                'amount' => $request->amount,
                'source' => $request->source,
                'note' => $request->note,
                'ref' => $request->ref,
            ]);

            return response()->json($transaction, 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function show($id): JsonResponse
    {
        try {
            $transaction = Transaction::findOrFail($id);
            return response()->json($transaction, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'amount' => 'numeric',
            'note' => 'nullable|string',
            'ref' => 'integer',
        ]);

        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->update($request->only(['amount', 'note', 'ref']));
            return response()->json($transaction, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $request->validate([
            'keyword' => 'required|string',
        ]);

        $keyword = $request->input('keyword');

        $transactions = Transaction::query()
            ->select('transactions.*')
            ->join('users as sender', 'transactions.user_id', '=', 'sender.id')
            ->join('wallets', 'transactions.wallet_id', '=', 'wallets.id')
            ->leftJoin('users as recipient', 'wallets.user_id', '=', 'recipient.id')
            ->where('sender.name', 'like', "%$keyword%")
            ->orWhere('sender.email', 'like', "%$keyword%")
            ->orWhere('recipient.name', 'like', "%$keyword%")
            ->orWhere('recipient.email', 'like', "%$keyword%")
            ->get();

        return response()->json($transactions);
    }


    public function delete($id): JsonResponse
    {
        try {
            $transaction = Transaction::findOrFail($id);
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

}
