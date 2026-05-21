<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWinnerMail extends Mailable
{
    use SerializesModels;

    public $winner;

    public function __construct($winner)
    {
        $this->winner = $winner;
    }

    public function build()
    {
        return $this->subject('Auction Winner Confirmation')
            ->view('emails.auction_winner');
    }
}