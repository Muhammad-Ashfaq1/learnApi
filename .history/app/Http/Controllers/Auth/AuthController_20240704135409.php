<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile_number' => 'required|string|max:15|unique:users',
            'gender' => 'required|in:1,2',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $otp = rand(1000, 9999);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_number' => $request->mobile_number,
            'gender' => $request->gender,
            'password' => Hash::make($request->password),
            'otp' => $otp,
        ]);

        // Mail::to($user->email)->send(new OtpMail($otp));

        return response()->json(['message' => 'User registered successfully. Please check your email for OTP.']);
    }

}
