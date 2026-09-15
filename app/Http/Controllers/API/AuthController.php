<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $token = JWTAuth::fromUser($user);


        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => [
                'user' => $user,
                'token' => $this->respondWithToken($token),
            ],
        ], Response::HTTP_CREATED);
    }


    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ];
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');


        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid credentials',
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Could not create token',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return response()->json([
            'status' => true,
            'message' => 'User logged in successfully',
            'data' => [
                'user' => JWTAuth::user(),
                'token' => $this->respondWithToken($token),
            ],
        ], Response::HTTP_OK);
    }


    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'status' => true,
                'message' => 'User logged out successfully',
            ], Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'failed to logout',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function user()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            return response()->json([
                'status' => true,
                'message' => 'User profile fetched successfully',
                'data' => $user,
            ], Response::HTTP_OK);
        } catch (JWTException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token is invalid or expired',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
