<?php
namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Auth\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    public function __invoke()
    {
        $profile = auth()->user();
        return new ProfileResource($profile);
    }
}
