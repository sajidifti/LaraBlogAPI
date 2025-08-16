<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Auth PasswordResetController index']);
    }
}