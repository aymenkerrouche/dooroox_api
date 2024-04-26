<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialiteController extends Controller
{
    public function handleProviderCallback(Request $request): JsonResponse
    {
        $validator = Validator::make($request->only('provider', 'access_provider_token'), [
            'provider' => ['required', 'string'],
            'access_provider_token' => ['required', 'string']
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $provider = $request->provider;
        $validated = $this->validateProvider($provider);

        if (!is_null($validated)) {
            return $validated;
        }

        // Disable SSL verification for this request
        $response = Http::withoutVerifying()->get('https://www.googleapis.com/oauth2/v3/userinfo', [
            'access_token' => $request->access_provider_token,
        ]);

        // Handle response
        $providerUser = $response->json();

        $user = User::firstOrCreate(
            [
                'email' => $providerUser['email'],
            ],
            [
                'name' => $providerUser['name'] ,
                'profile_photo_path' => $providerUser['picture'],
            ]
        );

        if($user->profile_photo_path === null) {
            $user->profile_photo_path = $providerUser['picture'];
            $user->save();
        }        

        $email = $providerUser['email'];
        $data =  [
            'token' => $user->createToken($email)->plainTextToken,
            'user' => $user,
        ];

        return response()->json($data, 200);
    }

    protected function validateProvider($provider)
    {
        if (!in_array($provider, ['google'])) {
            return response()->json(["message" => 'You can only login via Google account'], 400);
        }
    }
}


/*
 $validator = Validator::make($request->only('provider', 'access_provider_token'), [
            'provider' => ['required', 'string'],
            'access_provider_token' => ['required', 'string']
        ]);
        if ($validator->fails())
            return response()->json($validator->errors(), 400);
        $provider = $request->provider;
        $validated = $this->validateProvider($provider);
        if (!is_null($validated))
            return $validated;
        $providerUser = Socialite::driver($provider)->userFromToken($request->access_provider_token);
        $user = User::firstOrCreate(
            [
                'email' => $providerUser->getEmail()
            ],
            [
                'name' => $providerUser->getName(),
            ]
        );
        $data =  [
            'token' => $user->createToken('Sanctom+Socialite')->plainTextToken,
            'user' => $user,
        ];
        return response()->json($data, 200);
 */
