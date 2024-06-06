<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function signup(SignupRequest $request)
    {
        
        User::create($request->all());
        
        return response()->json([
           'message' => 'User created successfully',
           'status' => Response::HTTP_CREATED
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email',  $request->email)->first();

        if (! $user || ! \Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => ['Username or password are incorrect'],
                'status' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        $user->tokens()->delete(); // revoke other tokens

        return response()->json([
            'status' => Response::HTTP_OK,
            'message' => 'User logged in successfully',
            'token' => $user->createToken('auth_token')->plainTextToken,
        ]);
    }

    public function logout(Request $request)
{
    // if (! $request->user()) {
    //     return response()->json([
    //         'message' => ['No user is currently logged in'],
    //         'status' => Response::HTTP_UNAUTHORIZED,
    //     ], Response::HTTP_UNAUTHORIZED);
    // }
    
    $request->user()->token()->revoke();

    return response()->json([
        'message' => ['Successfully logged out'],
        'status' => Response::HTTP_OK,
    ], Response::HTTP_OK);
}
}
