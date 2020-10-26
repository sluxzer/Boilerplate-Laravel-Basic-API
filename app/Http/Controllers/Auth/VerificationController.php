<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index(){
        return response()->json([
            'status' => false,
            'message' => 'User unverified',
        ], 401);
    }

    public function verify($user_id, Request $request) {
        if (!$request->hasValidSignature()) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid or Expired URL',
            ], 401);
        }

        $user = User::findOrFail($user_id);

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return response()->json([
            'status' => true,
            'message' => 'Success Verified',
        ], 200);
    }

    public function resend(Request $request) {
        if ($request->user()->hasVerifiedEmail()) {

            return response()->json([
                'status' => true,
                'message' => 'Email already verified.',
            ], 400);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json([
            'status' => true,
            'message' => 'Email verification link sent on your email',
        ], 200);
    }
}
