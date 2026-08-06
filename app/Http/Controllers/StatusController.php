<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subdomain;
use App\Models\EmailSatker;
use App\Models\EmailPribadi;

class StatusController extends Controller
{
        public function progres(Request $request)
    {
        $ticket = trim($request->ticket);

        $subdomain = Subdomain::where('nomor_tiket', $ticket)->first();

        $emailSatker = EmailSatker::where('nomor_tiket', $ticket)->first();

        $emailPribadi = EmailPribadi::where('nomor_tiket', $ticket)->first();

        return view('status-progres', compact(
            'ticket',
            'subdomain',
            'emailSatker',
            'emailPribadi'
        ));
    }
}