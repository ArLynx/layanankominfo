<?php

namespace App\Http\Controllers;

use App\Models\RequestApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PimpinanController extends Controller
{
    public function index()
    {
        // Statistics
        $stats = [
            'total' => RequestApplication::count(),
            'terbuka' => RequestApplication::where('status', 'terbuka')->count(),
            'proses' => RequestApplication::where('status', 'proses')->count(),
            'ditunda' => RequestApplication::where('status', 'ditunda')->count(),
            'selesai' => RequestApplication::where('status', 'selesai')->count(),
            'tutup' => RequestApplication::where('status', 'tutup')->count(),
            'rejected' => RequestApplication::where('status', 'rejected')->count(),
        ];

        // List of all applications
        $applications = RequestApplication::with('user')
                        ->latest()
                        ->paginate(15);

        return view('pimpinan.dashboard', compact('stats', 'applications'));
    }
}
