<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\VerifyotpRequest;

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

        LogUserRegistration::dispatch($request->mobile_number, $otp);


        return response()->json(['message' => 'User registered successfully. verify OTP.']);
        if ($request->fails()) {
            return response()->json(['errors' => $request->errors()], 422);
        }
    }
    public function verifyOtp(VerifyotpRequest $request)
    {
       

       

        $user = User::where('mobile_number', $request->mobile_number)->where('otp', $request->otp)->first();

        if ($user) {
            $user->update(['otp_verified' => true, ]);
            return response()->json(['message' => 'OTP verified successfully.']);
        }
        

        return response()->json(['message' => 'Invalid OTP.'], 400);
    }

}
