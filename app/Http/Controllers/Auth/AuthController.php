<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        try {
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Wrong username or password'
                ]);
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new \Exception('Error in Login');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'Success Login',
                'data' => [
                    'access_token' => $tokenResult,
                ]
            ]);
        } catch (\Exception $error) {
            return response()->json([
                'status' => false,
                'message' => 'Error Login',
                'data' => $error->getMessage(),
            ]);
        }
    }

    public function logout(Request $request){
        try{
            // Revoke the user's current token...
            $request->user()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Success logout',
            ], 200);
        }catch (\Exception $exception){
            return response()->json([
                'status' => false,
                'message' => 'Logout Error',
            ]);
        }
    }
}
