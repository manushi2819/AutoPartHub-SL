<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class OrderConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Order $order;
    public Collection $items;

    /**
     * @param Order $order
     * @param \Illuminate\Support\Collection<int, OrderItem>|OrderItem $items One item or a collection of items (same vendor) whose status just changed.
     */
    public function __construct(Order $order, $items)
    {
        $this->order = $order;
        $this->items = $items instanceof Collection ? $items : collect([$items]);
    }

    public function build()
    {
        return $this->subject('Your Order #' . $this->order->order_number . ' is Confirmed')
            ->view('emails.order_confirmed')
            ->with([
                'order' => $this->order,
                'items' => $this->items,
            ]);
    }
}