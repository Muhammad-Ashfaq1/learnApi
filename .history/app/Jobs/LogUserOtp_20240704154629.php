<?php
// app/Jobs/LogUserRegistration.php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class  implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mobileNumber;
    protected $otp;

    /**
     * Create a new job instance.
     *
     * @param string $mobileNumber
     * @param string $otp
     * @return void
     */
    public function __construct($mobileNumber, $otp)
    {
        $this->mobileNumber = $mobileNumber;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('User registered successfully.', [
            'mobile_number' => $this->mobileNumber,
            'otp' => $this->otp,
        ]);
    }
}
