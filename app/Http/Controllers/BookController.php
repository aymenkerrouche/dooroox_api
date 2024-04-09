<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Prof;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function get_book(): JsonResponse
    {
        $books = Book::all();
        return response()->json(['data' => $books]);
    }

    public function add_book(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'path' => 'required|string',
            'prof_id' => 'required|exists:profs,id',
        ]);

        try {
            // Begin a database transaction
            DB::beginTransaction();

            $book = Book::create($validatedData);

            DB::commit();

            return response()->json(['message' => 'Book added successfully', 'data' => $book]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Failed to add book: ' . $e->getMessage()], 500);
        }
    }

    public function update_book( $id, Request $request):JsonResponse
    {
        $request->validate([            'title' => 'string',
            'author' => 'string',
            'description' => 'string',
            'price' => 'numeric|min:0',
            'path' => 'string',
            'prof_id' => 'exists:profs,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json($book, 200);
    }

    public function delete_book($id): JsonResponse
    {

            $level = Level::findOrFail($id);
            $level->delete();
            return response()->json(['message' => 'Level deleted successfully']);
        }



}
