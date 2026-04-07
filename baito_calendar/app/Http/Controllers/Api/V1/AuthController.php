<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Requests\ResendVerificationEmail;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\JsonResponse;


final class AuthController extends ApiController
{
    public function register(RegisterRequest $request){
        $data = $request->validated();
        $user = User::create($data);
        $user->sendEmailVerificationNotification();
        $token = $user->createToken('auth-token')->plainTextToken;
        return $this->created([
            'user' => new UserResource($user),
            'token' => $token,
        ], 'User created successfully. Please check your email to verify your account.');
    }

    public function login(LoginRequest $request){
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (!$user || Hash::check($data["password"], $user->password)){
            throw ValidationException::withMessages([
                'email'=>['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('web')->plainTextToken;
        return response()->json(['message'=>'Login successful', 'user'=> new UserResource($user), 'token'=>$token]);
    }

    public function logout(Request $request){
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->noContent();
    }

    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()){
            return $this->success(message: 'Email already verified');
        }

        if ($user->markEmailAsVerified()){
            event(new Verified($user));
        }

        return $this->success(message: 'Email verified successfully');
    }

    public function resendVerificationEmail(ResendVerificationEmail $request): JsonResponse
    {
        $user = User::query()->where('email', $request->email)->first();
        
        if(!$user){
            return $this->notFound('User not found');
        }

        if($user->hasVerifiedEmail()){
            return $this->error('Email already verified', 400);
        }

        $user->sendEmailVerificationNotification();

        return $this->success(message: 'Verification email sent successfully');
    }

    public function forgotPassword(ForgotPasswordRequest $request){

        $status = Password::sendResetLink($request->only('email'));
        if($status === Password::RESET_LINK_SENT){
            return $this->success(message: 'Password reset link sent to your email');
        }
        return $this->error('Unable to send reset link', 500);

    }

    public function resetPassword(ResetPasswordRequest $request):JsonResponse
    {
        // process of reseting password accepts user info(email, password, password_confirmation , token) and callback(anonymous function that works if info is ok) function 
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password):void{
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
                $user->tokens()->delete();
                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET){
            return $this->success(message: 'Password reset successfully');
        }
        return $this->error(
            match($status){
                Password::INVALID_TOKEN=> 'Invalid or expired token',
                Password::INVALID_USER=>'User not found',
                default =>'Unable to reset password',
            },
            400
        );
    }
}
