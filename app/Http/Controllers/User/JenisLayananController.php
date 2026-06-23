<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JenisLayananController extends Controller
{
    public function index()
    {
        return view('user.layanan.index');
    }
}
