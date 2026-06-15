<?php

namespace App\Http\Controllers;

use App\Models\RequestApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequestController extends Controller
{
    public function index()
    {
        $applications = RequestApplication::where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('requests.index', compact('applications'));
    }

    public function create()
    {
        $user = Auth::user();

        if (empty($user->nik) || empty($user->instansi)) {
            return redirect()->route('profile.show')
                ->with('warning', 'Silakan lengkapi data profil Anda terlebih dahulu sebelum mengajukan layanan.');
        }

        return view('requests.service');
    }

    public function store(Request $request)
    {
        // 1. Common Validation
        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:subdomain,email_pribadi,email_satker',
            'reason' => 'required|string|min:10',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // 2. Dynamic Validation based on type
        if ($request->type === 'subdomain') {
            $validator->addRules([
                'details.proposed_subdomain' => 'required|string|max:255',
                'details.pic_name' => 'required|string|max:255',
                'details.pic_contact' => 'required|string|max:20',
            ]);
        } elseif ($request->type === 'email_pribadi') {
            $validator->addRules([
                'details.nama' => 'required|string|max:255',
                'details.nip' => 'required|string|max:20',
                'details.jabatan' => 'required|string|max:255',
                'details.instansi' => 'required|string|max:255',
                'details.email' => 'required|email|max:255',
                'details.no_hp_wa' => 'required|string|max:20',
                'details.nama_akun' => 'required|string|max:255',
                'details.jenis_layanan' => 'required|string|in:baru,reset,hapus,ganti',
                'details.nama_pemohon' => 'required|string|max:255',
                'details.pengajuan_untuk' => 'required|string|in:diri_sendiri,orang_lain',
            ]);
        } elseif ($request->type === 'email_satker') {
            $validator->addRules([
                'details.nama_instansi' => 'required|string|max:255',
                'details.nama_akun' => 'required|string|max:255',
                'details.nama_pj' => 'required|string|max:255',
                'details.nip' => 'required|string|max:20',
                'details.jabatan' => 'required|string|max:255',
                'details.email_pribadi' => 'required|email|max:255',
                'details.no_hp_wa' => 'required|string|max:20',
                'details.jenis_layanan' => 'required|string|in:reset,ganti,pj',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('applications/documents', 'public');
        }

        $application = RequestApplication::create([
            'user_id' => Auth::id(),
            'type' => $request->type,
            'details' => $request->details,
            'reason' => $request->reason,
            'document_path' => $documentPath,
            'status' => 'terbuka',
        ]);

        return redirect()->route('requests.success', $application->id)->with('success', 'Permohonan berhasil dikirim.');
    }

    public function success($id)
    {
        $application = RequestApplication::findOrFail($id);
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }
        return view('requests.success', compact('application'));
    }

    public function edit(Request $request, $id)
    {
        $application = RequestApplication::findOrFail($id);
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }
        if ($application->status !== 'rejected') {
            return redirect()->route('requests.index')->with('error', 'Hanya pengajuan yang ditolak yang dapat diedit.');
        }
        return view('requests.edit', compact('application'));
    }

    public function update(Request $request, $id)
    {
        $application = RequestApplication::findOrFail($id);
        if ($application->user_id !== Auth::id()) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'type' => 'required|string|in:subdomain,email_pribadi,email_satker',
            'reason' => 'required|string|min:10',
            'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->type === 'subdomain') {
            $validator->addRules([
                'details.proposed_subdomain' => 'required|string|max:255',
                'details.pic_name' => 'required|string|max:255',
                'details.pic_contact' => 'required|string|max:20',
            ]);
        } elseif ($request->type === 'email_pribadi') {
            $validator->addRules([
                'details.nama' => 'required|string|max:255',
                'details.nip' => 'required|string|max:20',
                'details.jabatan' => 'required|string|max:255',
                'details.instansi' => 'required|string|max:255',
                'details.email' => 'required|email|max:255',
                'details.no_hp_wa' => 'required|string|max:20',
                'details.nama_akun' => 'required|string|max:255',
                'details.jenis_layanan' => 'required|string|in:baru,reset,hapus,ganti',
                'details.nama_pemohon' => 'required|string|max:255',
                'details.pengajuan_untuk' => 'required|string|in:diri_sendiri,orang_lain',
            ]);
        } elseif ($request->type === 'email_satker') {
            $validator->addRules([
                'details.nama_instansi' => 'required|string|max:255',
                'details.nama_akun' => 'required|string|max:255',
                'details.nama_pj' => 'required|string|max:255',
                'details.nip' => 'required|string|max:20',
                'details.jabatan' => 'required|string|max:255',
                'details.email_pribadi' => 'required|email|max:255',
                'details.no_hp_wa' => 'required|string|max:20',
                'details.jenis_layanan' => 'required|string|in:reset,ganti,pj',
            ]);
        }

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $documentPath = $application->document_path;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('applications/documents', 'public');
        }

        $application->update([
            'type' => $request->type,
            'details' => $request->details,
            'reason' => $request->reason,
            'document_path' => $documentPath,
            'status' => 'terbuka',
        ]);

        return redirect()->route('requests.index')->with('success', 'Pengajuan berhasil diperbarui dan dikirim kembali.');
    }
}
