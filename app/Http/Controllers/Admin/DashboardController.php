<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $activeAdmins = User::where('role', 'admin')->where('status', 'active')->count();
        $regularUsers = User::where('role', 'user')->count();

        $users = User::paginate(10);

        return view('admin.dashboard', compact('totalUsers', 'activeAdmins', 'regularUsers', 'users'));
    }
}