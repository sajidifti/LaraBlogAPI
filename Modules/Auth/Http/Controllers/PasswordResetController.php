<?php
namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Requests\PasswordResetRequest;
use Modules\Auth\Jobs\PasswordResetEmailJob;
use Modules\Auth\Models\PasswordResetOtp;

class PasswordResetController extends Controller
{
    public function __invoke(PasswordResetRequest $request)
    {
        $validated = $request->validated();

        $otp = rand(100000, 999999);

        PasswordResetOtp::updateOrCreate(
            ['email' => $validated['email']],
            ['otp' => $otp, 'expires_at' => now()->addMinutes(5)]
        );

        PasswordResetEmailJob::dispatch($validated['email'], $otp);

        return response()->json(['message' => 'OTP sent successfully']);
    }
}
