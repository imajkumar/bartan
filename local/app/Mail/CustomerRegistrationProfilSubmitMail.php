<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerRegistrationProfilSubmitMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        
        $this->customer =  $customer;
         //pr($customer);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->view('emails.CustomerRegistrationProfilSubmitMail')
        ->subject('Successful Submission of  A1 connect profile')
        
        ->with([
            'name' => @$this->customer->name,
            'email' => $this->customer->email,
            
            
        ]);
    }
}
