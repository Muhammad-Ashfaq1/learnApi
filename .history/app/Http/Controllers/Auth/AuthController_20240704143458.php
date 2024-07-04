<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(SignupRequest $request)
    {
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
        if ($request->fails()) {
            return response()->json(['errors' => $request->errors()], 422);
        }
    }
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|string|max:15|exists:users,mobile_number',
            'otp' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('mobile_number', $request->mobile_number)->where('otp', $request->otp)->first();

        if ($user) {
            $user->update(['is_verified' => true, 'otp' => null]);
            return response()->json(['message' => 'OTP verified successfully.']);
        }

        return response()->json(['message' => 'Invalid OTP.'], 400);
    }

}
