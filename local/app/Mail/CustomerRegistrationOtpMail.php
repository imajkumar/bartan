<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerRegistrationOtpMail extends Mailable
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
        
        return $this->view('emails.CustomerRegistrationOtpMail')
        ->subject('OTP to login into your account')
        
        ->with([
            'name' => @$this->customer->name,
            'email' => $this->customer->email,
            'otp' => $this->customer->otp,
            
        ]);
    }
}
