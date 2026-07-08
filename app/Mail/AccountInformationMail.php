<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountInformationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    protected $pdfPath;

    protected $viewName;

    public function __construct(
        $data,
        string $pdfPath,
        string $view = 'emails.account-information'
    ) {
        $this->data = $data;
        $this->pdfPath = $pdfPath;
        $this->viewName = $view;
    }

    public function build()
    {
        return $this
            ->subject('Informasi Akun Email Resmi')
            ->view($this->viewName)
            ->with([
                'data' => $this->data,
            ])
            ->attach(
                $this->pdfPath,
                [
                    'as' => 'Informasi-Akun-Email.pdf',
                    'mime' => 'application/pdf',
                ]
            );
    }
}