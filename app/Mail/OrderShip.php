<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShip extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $infoDemo;
    public function __construct($infoDemo)
    {
        //
        $this->infoDemo = $infoDemo;
    } 
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from("vanni4018@gmail.com","Ni Dep Trai")
        ->subject('[NICOLAI.VN] BackEnd Developer')
        ->view('mail.order')
        ->with($this->infoDemo);
    }
}
