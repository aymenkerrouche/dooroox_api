<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller 
{

    public function update_me(Request $request)
    {
        $user = auth()->user();

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

        return response()->json(['message' => 'Profile updated.', 'user' => $user]);
    }

    public function update($id)
    {
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

        return response()->json(['message' => 'Profile updated.', 'user' => $user]);
    }

    public function show($id) {

         $user = User::user()->find($id);

         return response()->json(['user' => $user]);
    }

    public function get_me() {

        $user = auth()->user();
        return response([
            'user' => $user
        ], 200);
    }


    public function destroy_me() {
        $user = auth()->user();
        Auth::logout();
        $user->delete();
        return response()->json(['message' => 'Your account deleted successfully']);
    }

    public function destroy($id){
        $user = User::user()->find($id);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }

}
