<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request){
        $data = $request->validated();
        User::create($data);
        return response()->json($data);
    }

    public function login(LoginRequest $request){
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || Hash::check($data["password"], $user->password)){
            throw ValidationException::withMessages([
                'email'=>['The provided credentials are incorrect.'],
            ]);
        }
        // if (!$user->email_verified_at){
        //     throw ValidationException::withMessages([
        //         'email'=>'Please validate your email first'
        //     ]);
        // }
        $token = $user->createToken('web')->plainTextToken;
        return response()->json(['message'=>'Login successful', 'user'=> new UserResource($user), 'token'=>$token]);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->noContent();
    }
}
