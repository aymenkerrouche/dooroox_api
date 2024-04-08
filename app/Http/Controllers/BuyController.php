<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BuyController extends Controller
{

  public function buy_book(Request $request): JsonResponse
  {
      $validatedData = $request->validate([
          'wallet_id' => 'required',
          'book_id' => 'required',
          'ref' => 'required|unique:buys',
      ]);

      try {
          // Begin a database transaction
          DB::beginTransaction();

          Buy::create([
              'wallet_id' => $validatedData['wallet_id'],
              'book_id' => $validatedData['book_id'],
              'ref' => $validatedData['ref'],
          ]);


          DB::commit();

          return response()->json(['message' => 'Book bought successfully']);

      } catch (\Exception $e) {

          DB::rollback();
          return response()->json(['Failed to buy book: ' . $e->getMessage()], 500);

  }
  }

}


