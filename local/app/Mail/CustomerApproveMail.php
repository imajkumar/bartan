<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerApproveMail extends Mailable
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
        // pr($this->details);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->subject('Mail from ItSolutionStuff.com')
        // ->view('emails.CustomerApproveMail');
        
        return $this->view('emails.CustomerApproveMail')
                    ->subject('Your Subhiksh id has been approved successfully')
                    ->with([
                        'fname' => $this->details['cutomer_fname'],
                        'lname' => $this->details['cutomer_lname'],
                    ]);
    }
}
