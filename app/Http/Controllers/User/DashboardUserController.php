<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subdomain;
use App\Models\EmailPribadi;
use App\Models\EmailSatker;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    // public function index()
    // {
    //     $user = auth()->user();

    //     $subdomains = Subdomain::where('user_id', $user->id)->oldest()->get();

    //     $emailPribadis = EmailPribadi::where('user_id', $user->id)->oldest()->get();

    //     $emailSatkers = EmailSatker::where('user_id', $user->id)->oldest()->get();

    //     return view('user.dashboard-user', compact('user', 'subdomains', 'emailPribadis', 'emailSatkers'));
    // }

    public function index()
    {
        $user = Auth::user();

        $subdomains = Subdomain::where('user_id', $user->id)->latest()->get();

        $emailSatkers = EmailSatker::where('user_id', $user->id)->latest()->get();

        $emailPribadis = EmailPribadi::where('user_id', $user->id)->latest()->get();

        return view('user.dashboard-user', compact('user', 'subdomains', 'emailSatkers', 'emailPribadis'));
    }
}
