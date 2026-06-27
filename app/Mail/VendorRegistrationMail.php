<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Vendor;

class VendorRegistrationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;
    public $plainPassword;

    public function __construct(Vendor $vendor, $plainPassword)
    {
        $this->vendor = $vendor;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Vendor Registration Received')
                    ->view('emails.vendor.registration')
                    ->with([
                        'vendor' => $this->vendor,
                        'password' => $this->plainPassword,
                    ]);
    }
}
