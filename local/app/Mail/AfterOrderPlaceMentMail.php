<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\ItemOrder;
use App\paymentStatus;
use DB;
use PDF;

class AfterOrderPlaceMentMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
        $this->ItemOrderCount = ItemOrder::where('order_id', $this->orderId)->count();
        $this->customer = ItemOrder::where('order_id', $this->orderId)->first();
        //echo $orderId;
        //pr($ItemOrderCount);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //$pdf = PDF::loadView('emails.myTestMail', $data);
        $pdf = genratePdfItemOrderByOrderId($this->orderId);
        //$pdf->download('Order.pdf');
        // return $this->view('view.name');
        return $this->view('emails.AfterOrderPlaceMentMail')
        ->subject('Your order '.$this->orderId.' of '.$this->ItemOrderCount.' is placed')
        ->attachData($pdf->output(), "order.pdf")
        ->with([
                'ItemOrderCount' => $this->ItemOrderCount,
                'customerId' => $this->customer->customer_id,
            ]);
    }
}
