<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(SignuRequest $request)
    {
      

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
