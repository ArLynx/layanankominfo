<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param  array<string, mixed>  $input
     */
    public function update(User $user, array $input): void
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nik' => ['nullable', 'string', 'max:255'],
            'instansi' => ['nullable', 'string', 'max:255'],
            'no_hp_wa' => ['nullable', 'string', 'max:255'],
            'status_pegawai' => ['nullable', 'string', 'max:255'],
            'kartu_pegawai' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'nik' => $input['nik'] ?? $user->nik,
                'instansi' => $input['instansi'] ?? $user->instansi,
                'no_hp_wa' => $input['no_hp_wa'] ?? $user->no_hp_wa,
                'status_pegawai' => $input['status_pegawai'] ?? $user->status_pegawai,
                'kartu_pegawai' => $input['kartu_pegawai'] ?? $user->kartu_pegawai,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param  array<string, string>  $input
     */
    protected function updateVerifiedUser(User $user, array $input): void
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'nik' => $input['nik'] ?? $user->nik,
            'instansi' => $input['instansi'] ?? $user->instansi,
            'no_hp_wa' => $input['no_hp_wa'] ?? $user->no_hp_wa,
            'status_pegawai' => $input['status_pegawai'] ?? $user->status_pegawai,
            'kartu_pegawai' => $input['kartu_pegawai'] ?? $user->kartu_pegawai,
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
