<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Vendor;

class AdminNewVendorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $vendor;

    public function __construct(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function build()
    {
        return $this->subject('New Vendor Registration Awaiting Approval')
                    ->view('emails.admin.new_vendor')
                    ->with([
                        'vendor' => $this->vendor,
                    ]);
    }
}
