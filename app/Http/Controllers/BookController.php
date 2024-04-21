<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(): JsonResponse
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'path' => 'required|string',
            'prof_id' => 'required|exists:profs,id',
        ]);

        Book::create($request->all());

        return response()->json(['message' => 'Book added successfully'], 201);
    }

    public function show($id): JsonResponse
    {
        $book = Book::findOrFail($id);
        return response()->json($book);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'path' => 'required|string',
            'prof_id' => 'required|exists:profs,id',
        ]);

        $book = Book::findOrFail($id);
        $book->update($request->all());

        return response()->json(['message' => 'Book updated successfully'], 200);
    }

    public function destroy($id): JsonResponse
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return response()->json(['message' => 'Book deleted successfully'], 200);
    }
}
