<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected $sid;
    protected $token;
    protected $from;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->from = config('services.twilio.from');
    }

    public function sendOtp($to, $otp)
    {
       
        $client = new Client($this->sid, $this->token);

        $message = $client->messages->create(
            $to,
            [
                'from' => $this->from,
                'body' => "Your OTP code is: {$otp}"
            ]
        );

        return $message->sid;
    }
}
