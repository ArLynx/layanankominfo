<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subdomain;
use App\Models\EmailSatker;
use App\Models\EmailPribadi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'subdomain');
        $search = $request->search;
        $status = $request->status;

        $subdomainCount = Subdomain::where('user_id', auth()->id())->count();
        $emailSatkerCount = EmailSatker::where('user_id', auth()->id())->count();
        $emailPribadiCount = EmailPribadi::where('user_id', auth()->id())->count();

        $subdomains = null;
        $emailSatkers = null;
        $emailPribadis = null;

        if ($tab == 'subdomain') {
            $subdomains = Subdomain::query()
                ->where('user_id', auth()->id())
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        $query->where('nomor_tiket', 'like', "%{$search}%")->orWhere('nama_subdomain', 'like', "%{$search}%");
                    });
                })
                ->when($status, fn($q) => $q->where('status', $status))
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif ($tab == 'email-satker') {
            $emailSatkers = EmailSatker::query()
                ->where('user_id', auth()->id())
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        $query->where('nomor_tiket', 'like', "%{$search}%")->orWhere('nama_akun_dinas', 'like', "%{$search}%");
                    });
                })
                ->when($status, fn($q) => $q->where('status', $status))
                ->latest()
                ->paginate(10)
                ->withQueryString();
        } elseif ($tab == 'email-pribadi') {
            $emailPribadis = EmailPribadi::query()
                ->where('user_id', auth()->id())
                ->when($search, function ($q) use ($search) {
                    $q->where(function ($query) use ($search) {
                        $query
                            ->where('nomor_tiket', 'like', "%{$search}%")
                            ->orWhere('nama', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                })
                ->when($status, fn($q) => $q->where('status', $status))
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('user.riwayat.index', compact('subdomains', 'emailSatkers', 'emailPribadis', 'subdomainCount', 'emailSatkerCount', 'emailPribadiCount'));
    }
}
