<?php

namespace App\Livewire\User;

use Livewire\Component;

class TwoFactorSetupPage extends Component
{
    public bool $enabled = false;

    public function mount(): void
    {
        $user = auth()->user();
        $this->enabled = $user?->two_factor_confirmed_at !== null;
    }

    public function checkStatus(): void
    {
        $user = auth()->user();
        $this->enabled = $user?->two_factor_confirmed_at !== null;
    }

    public function render()
    {
        return view('livewire.user.two-factor-setup-page');
    }
}