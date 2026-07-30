<?php

namespace App\Livewire\Admin;

use Livewire\Component;

class TwoFactorSetupPage extends Component
{
    public bool $enabled = false;

    public function mount(): void
    {
        $admin = auth('admin')->user();
        $this->enabled = $admin?->two_factor_confirmed_at !== null;
    }

    public function checkStatus(): void
    {
        $admin = auth('admin')->user();
        $this->enabled = $admin?->two_factor_confirmed_at !== null;
    }

    public function render()
    {
        return view('livewire.admin.two-factor-setup-page');
    }
}