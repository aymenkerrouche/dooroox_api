<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

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

        return response()->json(['message' => 'Profile updated.']);
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

    public function showImage()
    {
        $user = auth()->user();
        $user_image = $user->profile_photo_path;
        return response([
            'profile_photo_path' => file(public_path("/storage/users/6Tw1S6CqshsFY0NXIUgnQWgxI7Kl85wsnPUH4tPr.jpg"))
        ],200);
    }


    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {

            try{
                $originalImage = $request->file('image');
                $image = Storage::disk('local')->put('public/users', $originalImage, 'public');

                $user = auth()->user();
        
                if ($user && $user->profile_photo_path) {
                    Storage::disk('local')->delete($user->profile_photo_path);
                }

                DB::table('users')->where('id',$user->id)->update(['profile_photo_path' => $image,]);

                return response([
                    'image' => 'First/storage/app/'.$image,
                ], 200);
            }
            catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
            
        }
    }

    public function deleteImage(){
        $user = auth()->user();
        
        if ($user && $user->profile_photo_path) {

            Storage::disk('local')->delete($user->profile_photo_path);
            
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
