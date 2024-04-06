<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function signUp(Request $request)
    {
        $request->validate([
            'name' =>'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',

        ]);

        // Check if user already exists

        $user = User::where('email', $request->email)->first();
        if ($user) {
            return response('The provided email already exists.', 403);
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        //create the user

        $user = User::create($input);

        $response['token'] = $user->createToken($request->email)->plainTextToken;
        $user = User::where('email', $request['email'])->first();
        $user_id = $user["id"];
        $response['user'] = $user;
        $response['user_id'] = $user_id;
        return response(json_encode($response), 201);
    }


    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/dashboard');
        } else {
            return response('The provided credentials are incorrect.', 403);
        }

        $user = User::where('email', $request['email'])->first();
        if (! $user || ! Hash::check($request->password, $user->password))

        {
            return response('The provided credentials are incorrect.', 403);
        }



    }


    public function logout(){
        auth()->user()->tokens()->delete();

        return response([
            'message' => 'Logout success.'
        ], 200);
    }



}









