<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function update_me(Request $request): JsonResponse
    {
        $user = auth()->user();

        try {

            if ($request->has('password')) {
                $request->validate([
                    'password' => 'sometimes|required|min:8',
                ]);

                $user->password = Hash::make($request->password);
            }

            if ($request->has('name')) {
                $request->validate([
                    'name' => 'sometimes|required',
                ]);
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $request->validate([
                    'email' => 'sometimes|required|unique',
                ]);
                $user->email = $request->email;
            }

            if ($request->has('profile_photo_path')) {
                $user->profile_photo_path = $request->profile_photo_path;
            }

            $user->save();

            return response()->json(['message' => 'Profile updated.', 'data' => null, 'error' => null]);
        } catch (\Exception $e) {
            return response()->json(['message' => null, 'data' => null, 'error' => $e->getMessage()], 500);
        } }

    public function update($id, Request $request): JsonResponse
    {
        try {
            $user = User::user()->find($id);

            if ($request->has('password')) {
                $request->validate([
                    'password' => 'sometimes|required|min:8',
                ]);

                $user->password = Hash::make($request->password);
            }

            if ($request->has('name')) {
                $request->validate([
                    'name' => 'sometimes|required',
                ]);
                $user->name = $request->name;
            }

            if ($request->has('email')) {
                $request->validate([
                    'email' => 'sometimes|required|unique',
                ]);
                $user->email = $request->email;
            }

            if ($request->has('profile_photo_path')) {
                $user->profile_photo_path = $request->profile_photo_path;
            }

            $user->save();

            return response()->json([
                'message' => 'Profile updated.',
                'user' => $user,
                'error' => null]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'user' => null,
                'error' => $e->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {

        try {
            $user = User::user()->find($id);
            return response()->json([
                'message' => 'User found successfully',
                'data' => $user, '
                error' => null], 200);

        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage()], 404);
        }
    }

    public function get_me(): JsonResponse
    {

        try {
            $user = auth()->user();
            return response()->json([
                'message' => 'User retrieved successfully',
                'data' => $user,
                'error' => null], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
                'error' => $e->getMessage()], 500);
        }
    }


    public function destroy_me() {
        try {
            $user = auth()->user();
            Auth::logout();
            $user->delete();
            return response()->json([
                'message' => 'Your account was deleted successfully',
                'data' => null,
                'error' => null], 200);


        } catch (Exception $e) {
            return response()->json([
                'message' => null,
                'data' => null,
               ' error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id){
        try {
            $user = User::user()->find($id);
            $user->delete();
            return response()->json(['
            message' => 'User deleted successfully',
                'data' => null,
                'error' => null], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => null,
               ' data' => null,
                'error' => $e->getMessage()], 404);
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {

            try{
                $originalImage = $request->file('image');
                $image = Storage::disk('photo')->put('/users', $originalImage, 'public');

                $user = auth()->user();

                if ($user && $user->profile_photo_path) {
                    Storage::disk('photo')->delete($user->profile_photo_path);
                }

                DB::table('users')->where('id',$user->id)->update(['profile_photo_path' => $image,]);

                return response()->json(['data' => $image,'error' => 'null'], 200);
            }
            catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }
    }

    public function deleteImage(){
        $user = auth()->user();

        if ($user && $user->profile_photo_path) {

            Storage::disk('photo')->delete($user->profile_photo_path);

            $user->profile_photo_path = null;
            $user->save();

            return response()->json([
                'message' => 'Profile image deleted successfully'
            ], 200);
        }

        return response()->json([
            'message' => 'User does not have a profile image'
        ], 400);
    }


}
