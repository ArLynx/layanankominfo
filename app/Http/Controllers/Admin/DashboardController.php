<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subdomain;
use App\Models\EmailSatker;
use App\Models\EmailPribadi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;

        if (!in_array($role, ['admin', 'superadmin'])) {
            abort(403, 'Unauthorized access');
        }

        if ($role === 'superadmin') {
            $totalUsers = User::count();
            $activeAdmins = User::where('role', 'admin')->where('status', 'active')->count();
            $regularUsers = User::where('role', 'user')->count();
            $users = User::paginate(10);

            return view('superadmin.dashboard', compact('totalUsers', 'activeAdmins', 'regularUsers', 'users'));
        }

        $totalSubdomain = Subdomain::count();
        $totalEmailSatker = EmailSatker::count();
        $totalEmailPribadi = EmailPribadi::count();
        $totalPengajuan = $totalSubdomain + $totalEmailSatker + $totalEmailPribadi;

        $pendingSubdomain = Subdomain::where('status', 'pending')->count();
        $pendingEmailSatker = EmailSatker::where('status', 'pending')->count();
        $pendingEmailPribadi = EmailPribadi::where('status', 'pending')->count();
        $totalPending = $pendingSubdomain + $pendingEmailSatker + $pendingEmailPribadi;

        $processedSubdomain = Subdomain::whereIn('status', ['approved', 'rejected', 'completed'])->count();
        $processedEmailSatker = EmailSatker::whereIn('status', ['approved', 'rejected', 'completed'])->count();
        $processedEmailPribadi = EmailPribadi::whereIn('status', ['approved', 'rejected', 'completed'])->count();
        $totalProcessed = $processedSubdomain + $processedEmailSatker + $processedEmailPribadi;

        return view('admin.dashboard', compact(
            'totalPengajuan', 'totalPending', 'totalProcessed',
            'totalSubdomain', 'totalEmailSatker', 'totalEmailPribadi',
            'pendingSubdomain', 'pendingEmailSatker', 'pendingEmailPribadi',
            'processedSubdomain', 'processedEmailSatker', 'processedEmailPribadi'
        ));
    }
}
