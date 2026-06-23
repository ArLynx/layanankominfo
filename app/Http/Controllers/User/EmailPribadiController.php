<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailPribadiController extends Controller
{
    public function create()
    {
        return view('user.email-pribadi.create');
    }
}
