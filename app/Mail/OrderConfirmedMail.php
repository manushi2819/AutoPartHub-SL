<?php

namespace App\Mail;

use App\Models\Order; // ✅ ADD THIS LINE
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        return $this->subject('Your Order is Confirmed')
                    ->view('emails.order_confirmed');
    }
}