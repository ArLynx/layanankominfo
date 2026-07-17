<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\Admin;
use App\Models\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        // ===============================
        // Notifikasi Superadmin
        // ===============================
        $superAdmins = Admin::where('role', 'superadmin')->get();

        foreach ($superAdmins as $superAdmin) {
            Notification::create([
                'recipient_type' => 'superadmin',
                'recipient_id' => $superAdmin->id,
                'title' => 'User Baru Mendaftar',
                'message' => 'User: ' . $user->name . ' (' . $user->email . ')',
                'type' => 'user_registration',
                'reference_type' => 'user',
                'reference_id' => $user->id,
                'url' => route('admin.notifications.index'),
                'is_read' => false,
            ]);
        }

        return $user;
    }
}
