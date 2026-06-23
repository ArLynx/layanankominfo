<?php

namespace App\Services;

use App\Models\Subdomain;
use App\Models\EmailSatker;
use App\Models\EmailPribadi;

class TicketService
{
    public function generateSubdomainTicket(): string
    {
        $today = now()->format('Ymd');

        $lastTicket = Subdomain::whereDate('created_at', today())
            ->latest('id')
            ->first();

        $number = 1;

        if ($lastTicket) {
            $parts = explode('-', $lastTicket->nomor_tiket);
            $number = ((int) end($parts)) + 1;
        }

        return sprintf(
            'SUB-%s-%04d',
            $today,
            $number
        );
    }

    public function generateEmailSatkerTicket(): string
    {
        $today = now()->format('Ymd');

        $lastTicket = EmailSatker::whereDate('created_at', today())
            ->latest('id')
            ->first();

        $number = 1;

        if ($lastTicket) {
            $parts = explode('-', $lastTicket->nomor_tiket);
            $number = ((int) end($parts)) + 1;
        }

        return sprintf(
            'EMS-%s-%04d',
            $today,
            $number
        );
    }

    public function generateEmailPribadiTicket(): string
    {
        $today = now()->format('Ymd');

        $lastTicket = EmailPribadi::whereDate('created_at', today())
            ->latest('id')
            ->first();

        $number = 1;

        if ($lastTicket) {
            $parts = explode('-', $lastTicket->nomor_tiket);
            $number = ((int) end($parts)) + 1;
        }

        return sprintf(
            'EMP-%s-%04d',
            $today,
            $number
        );
    }
}