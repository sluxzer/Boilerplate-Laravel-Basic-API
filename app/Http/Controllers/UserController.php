<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function me(Request $request){
        try{
            return response()->json([
                'status' => true,
                'message' => 'Success get profile',
                'data' => $request->user()
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status' => false,
                'message' => 'Something wrong while get profile',
            ]);
        }
    }

    public function changePassword(Request $request){
        try{
            $this->validate($request, [
                'password' => 'required',
                'password_confirmation' => 'required|same:password',
            ]);

            $user = $request->user();
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Success change password',
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status' => false,
                'message' => 'Something wrong while change password',
            ]);
        }
    }

    public function changeProfile(Request $request){
        try{
            $this->validate($request, [
                'name' => 'required',
            ]);

            $user = $request->user();
            $user->name = Str::title($request->name);
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Success update profile',
            ]);
        }catch (\Exception $exception){
            return response()->json([
                'status' => false,
                'message' => 'Something wrong while update password',
            ]);
        }
    }
}
