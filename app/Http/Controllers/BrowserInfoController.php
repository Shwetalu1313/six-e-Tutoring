<?php

namespace App\Http\Controllers;

use App\Events\BrowserInfoReceived;
use App\Models\BrowserInfo;
use App\Models\User;
use Illuminate\Http\Request;

class BrowserInfoController extends Controller
{
    public function store(Request $request)
    {
        $email = $request->input('email');

        // Look up the user by email
        $user = User::where('email', $email)->first();

        // If user found, associate browser information with user ID
        if ($user) {
            BrowserInfo::create([
                'user_id' => $user->id,
                'browser' => $request->header('User-Agent'),
                'ip' => $request->ip(),
            ]);
        }
    }
}
