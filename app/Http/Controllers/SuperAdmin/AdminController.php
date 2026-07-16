<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::latest()->paginate(10);
        return view('superadmin.admins.index', compact('admins'));
    }

    public function create()
    {
        return view('superadmin.admins.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['admin', 'superadmin', 'pimpinan'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'nik' => ['nullable', 'string', 'max:255'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'no_hp_wa' => ['nullable', 'string', 'max:255'],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['email_verified_at'] = now();

        Admin::create($validated);

        return redirect()->route('admin.admins')->with('success', 'Admin berhasil dibuat');
    }

    public function edit(Admin $admin)
    {
        return view('superadmin.admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('admins')->ignore($admin->id)],
            'role' => ['required', Rule::in(['admin', 'superadmin', 'pimpinan'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'nik' => ['nullable', 'string', 'max:255'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'no_hp_wa' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => ['string', 'min:8']]);
            $validated['password'] = Hash::make($request->password);
        }

        $admin->update($validated);

        return redirect()->route('admin.admins')->with('success', 'Admin berhasil diperbarui');
    }

    public function destroy(Admin $admin)
    {
        if ($admin->id === auth()->id()) {
            return redirect()->route('admin.admins')->with('error', 'Tidak dapat menghapus akun sendiri');
        }

        $admin->delete();
        return redirect()->route('admin.admins')->with('success', 'Admin berhasil dihapus');
    }

    public function resetPassword(Admin $admin)
    {
        $password = 'password123';
        $admin->update(['password' => Hash::make($password)]);
        return redirect()->route('admin.admins')->with('success', "Password {$admin->name} telah direset menjadi {$password}");
    }
}
