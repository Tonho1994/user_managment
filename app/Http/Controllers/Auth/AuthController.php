<?php
namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\ApiLoginRequest;

class AuthController extends Controller
{
    public function login(ApiLoginRequest $request)
    {
        try {
            $validated = $request->validated();
            $token = Auth::guard('api')->attempt(['email'=>$validated['email'],'password'=>$validated['password']]);
            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Wrong credentials',
                    'data' => [
                        'credentials' => 'Wrong credentials',
                    ]
                ], 401);
            }
            $user = Auth::guard('api')->user()->load(['roles'=>fn ($query) => $query->select('name')]);
            return response()->json([
                'status' => 'success',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Throwable $th) {
            Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'AC-01',
                'data' => [
                    'error' => 'Something went Wrong',
                ]
            ],500);
        }
    }

    public function logout()
    {
        try {
            Auth::guard('api')->logout();
            return response()->json([
                'status' => 'success',
                'message' => 'Successfully logged out',
            ]);
        } catch (\Throwable $th) {
            Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'AC-02',
                'data' => [
                    'error' => 'Something went Wrong',
                ]
            ],500);
        }
    }

    public function refresh()
    {
        try {
            return response()->json([
                'status' => 'success',
                'user' => Auth::guard('api')->user(),
                'authorisation' => [
                    'token' => Auth::guard('api')->refresh(),
                    'type' => 'bearer',
                ]
            ]);
        } catch (\Throwable $th) {
            Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'AC-03',
                'data' => [
                    'error' => 'Something went Wrong',
                ]
            ],500);
        }
    }

    public function user()
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'user' => Auth::user()
                ]
            ]);
        } catch (\Throwable $th) {
            Log::warning(__METHOD__."--->Line:".$th->getLine()."----->".$th->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'AC-04',
                'data' => [
                    'error' => 'Something went Wrong',
                ]
            ],500);
        }
    }

    /* public function register(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    } */
}