<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __invoke(ProfileRequest $request)
    {
        return response()->json(['message' => 'User ProfileController index']);
    }
}
