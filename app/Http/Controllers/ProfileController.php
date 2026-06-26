<?php

namespace App\Http\Controllers;

class ProfileController extends Controller
{
    public function show()
    {
        if (auth()->user()->role === 'user') {
            return view('user.profile');
        }

        return view('profile.show');
    }
}
