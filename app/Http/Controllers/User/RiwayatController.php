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
        $search = $request->search;
        $status = $request->status;
        $perPage = $request->per_page ?? 10;

        $subdomains = Subdomain::query()
            ->where('user_id', auth()->id())
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('nomor_tiket', 'like', "%{$search}%")->orWhere('nama_subdomain', 'like', "%{$search}%");
                });
            })
            ->when($status, fn($q) => $q->where('status', $status))
            ->oldest()
            ->paginate($perPage)
            ->withQueryString();

        $emailSatkers = EmailSatker::query()
            ->where('user_id', auth()->id())
            ->oldest()
            ->paginate($perPage, ['*'], 'satker_page');

        $emailPribadis = EmailPribadi::query()
            ->where('user_id', auth()->id())
            ->oldest()
            ->paginate($perPage, ['*'], 'pribadi_page');

        $subdomainCount = Subdomain::where('user_id', auth()->id())->count();

        $emailSatkerCount = EmailSatker::where('user_id', auth()->id())->count();

        $emailPribadiCount = EmailPribadi::where('user_id', auth()->id())->count();

        return view('user.riwayat.index', compact('subdomains', 'emailSatkers', 'emailPribadis', 'subdomainCount', 'emailSatkerCount', 'emailPribadiCount'));
    }
}
