<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class WishlistController extends Controller
{
    public function getMyWishlist(): JsonResponse
    {
        try {
            $student = Auth::user()->student;
            if (!$student) {
                throw new \Exception('Student not found', 404);
            }

            $wishlist = $student->wishlist;
            if (!$wishlist) {
                throw new \Exception('Student wishlist not found', 404);
            }

            return response()->json($wishlist->contents, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function getStudentWishlist($userId): JsonResponse
    {
        try {
            $validator = Validator::make(['user_id' => $userId], [
                'user_id' => 'required|exists:users,id',
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator->errors()->first(), 400);
            }

            $student = User::findOrFail($userId)->student;
            if (!$student) {
                throw new \Exception('Student not found', 404);
            }

            $wishlist = $student->wishlist;
            if (!$wishlist) {
                throw new \Exception('Student wishlist not found', 404);
            }

            return response()->json($wishlist->contents, 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function addToWishlist($contentId): JsonResponse
    {
        try {
            $student = Auth::user()->student;
            if (!$student) {
                throw new \Exception('Student not found', 404);
            }

            $wishlist = $student->wishlist;
            if (!$wishlist) {
                throw new \Exception('Student wishlist not found', 404);
            }

            $wishlist->contents()->attach($contentId);

            return response()->json(['message' => 'Content added to wishlist successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function removeFromWishlist($contentId): JsonResponse
    {
        try {
            $student = Auth::user()->student;
            if (!$student) {
                throw new \Exception('Student not found', 404);
            }

            $wishlist = $student->wishlist;
            if (!$wishlist) {
                throw new \Exception('Student wishlist not found', 404);
            }

            $wishlist->contents()->detach($contentId);

            return response()->json(['message' => 'Content removed from wishlist successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
