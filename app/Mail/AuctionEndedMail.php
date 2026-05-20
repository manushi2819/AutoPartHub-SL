<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionEndedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function build()
    {
        return $this->subject('Auction Ended')
            ->view('emails.auction_ended');
    }
}