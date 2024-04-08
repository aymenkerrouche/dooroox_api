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

    }

    public function update_book(Book $book)
    {

    }

    public function delete_book(Request $request, Book $book)
    {

    }
}
