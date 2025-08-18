<?php
namespace Modules\Auth\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class PasswordResetEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;
    protected string $otp;

    public function __construct(string $email, string $otp)
    {
        $this->email = $email;
        $this->otp   = $otp;
    }

    public function handle(): void
    {
        Mail::send('Auth::password_reset', ['otp' => $this->otp], function ($message) {
            $message->to($this->email)
                ->subject('Password Reset OTP');
        });
    }
}
