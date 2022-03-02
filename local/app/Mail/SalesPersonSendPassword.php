<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalesPersonSendPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->view('emails.SalesPersonSendPassword')
        ->subject('Your account has been Activated Successfully With "Bartan.com"')
                    ->with([
                        'name' => $this->details['seller_name'],
                        'seller_email' => $this->details['seller_email'],
                        'seller_phone' => $this->details['seller_phone'],
                        'seller_password' => $this->details['seller_password'],
                        'salesLoginUrl' => $this->details['salesLoginUrl'],
                        
                    ]);
    }
}
