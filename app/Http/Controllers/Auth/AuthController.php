<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\LogUserOtp;
use App\Services\TwilioService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\VerifyotpRequest;

class AuthController extends Controller
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }
    public function register(SignupRequest $request)
    {
      $otp = rand(1000, 9999);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile_number' => $request->mobile_number,
            'gender' => $request->gender,
            'password' => $request->password,
            'otp' => $otp,
        ]);

        //LogUserOtp::dispatch($request->mobile_number, $otp);

 try {
            $this->twilioService->sendOtp($request->mobile_number, $otp);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send OTP. Please try again.', 'message' => $e->getMessage()], 500);
        }

        return response()->json(['message' => 'User registered successfully. verify OTP.']);
//        if ($request->fails()) {
//            return response()->json(['errors' => $request->errors()], 422);
//        }
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
