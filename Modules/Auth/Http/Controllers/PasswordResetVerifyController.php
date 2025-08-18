<?php
namespace Modules\Auth\Http\Controllers;

use Carbon\Carbon;
use Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Models\PasswordResetOtp;
use Modules\Auth\Http\Requests\PasswordResetVerifyRequest;

class PasswordResetVerifyController extends Controller
{
    public function __invoke(PasswordResetVerifyRequest $request)
    {
        $validated = $request->validated();

        $otp = PasswordResetOtp::where('email', $validated['email'])
            ->where('otp', $validated['otp'])
            ->first();

        if (!$otp) {
            return response()->json(['message' => 'Invalid OTP'], 422);
        }

        if (Carbon::parse($otp->expires_at)->isPast()) {
            return response()->json(['message' => 'OTP expired'], 422);
        }

        $user = User::where('email', $validated['email'])->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $otp->delete();

        return response()->json(['message' => 'Password has been reset successfully.']);
    }
}
