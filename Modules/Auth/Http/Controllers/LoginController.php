<?php
namespace Modules\Auth\Http\Controllers;

use Modules\User\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $validated = $request->validated();

        $user = User::where('email', $validated['email'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'user'  => $user,
                'token' => $user->createToken('api')->plainTextToken,
            ]);
        }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }
}
