<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OrderInTransitMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public Collection $items;

    public function __construct(Order $order, $items)
    {
        $this->order = $order;
        $this->items = $items instanceof Collection ? $items : collect([$items]);
    }

    public function build()
    {
        return $this->subject('Your Order #' . $this->order->order_number . ' is On Its Way')
            ->view('emails.order_in_transit')
            ->with([
                'order' => $this->order,
                'items' => $this->items,
            ]);
    }
}