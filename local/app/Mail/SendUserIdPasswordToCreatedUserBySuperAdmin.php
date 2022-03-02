<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserIdPasswordToCreatedUserBySuperAdmin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details, $pass)
    {
        $this->pass = $pass;
        $this->details = $details;
        // echo $pass;
        // pr($details);
        // exit;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        return $this->view('emails.SendUserIdPasswordToCreatedUserBySuperAdmin')
        ->subject('Your account has been Created Successfully With "Bartan.com"')
                    ->with([
                        'name' => $this->details['name'],
                        'email' => $this->details['email'],
                        'mobile' => $this->details['mobile'],
                        'password' =>  $this->pass,
                        
                        
                    ]);
    }
}
