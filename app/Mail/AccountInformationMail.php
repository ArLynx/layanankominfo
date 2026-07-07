<?php

namespace App\Mail;

use App\Models\EmailSatker;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountInformationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $emailSatker;

    protected $pdfPath;

    public function __construct(
        EmailSatker $emailSatker,
        string $pdfPath
    ) {
        $this->emailSatker = $emailSatker;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this
            ->subject('Informasi Akun Email Resmi')
            ->view('emails.account-information')
            ->attach(
                $this->pdfPath,
                [
                    'as' => 'Informasi-Akun-Email.pdf',
                    'mime' => 'application/pdf',
                ]
            );
    }
}