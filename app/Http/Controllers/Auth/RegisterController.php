<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(StoreUser $request){
        try{
            // Create User
            $user = User::create($request->all());

            // Generate Token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Send Email Verification
            $user->sendEmailVerificationNotification();

            return response()->json([
                'status' => true,
                'message' => 'Success Register',
                'data' => [
                    'access_token' => $tokenResult,
                ]
            ]);
        }catch (\Exception $exception){
            return  $exception;
            return response()->json([
                'status' => false,
                'message' => 'Something wrong.',
                'data' => $exception->getMessage()
            ]);
        }

    }
}
