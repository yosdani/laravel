<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Hash;
use App\Incidence;

class IncidenceMails extends Mailable
{
    use Queueable, SerializesModels;

    public $incidence;
    public $email;
    public $title;
    public $image_uri;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Incidence $incidence,string $image_uri,string $title)
    {
        $this->incidence = $incidence;
        $this->title = $title;
        $this->image_uri = $image_uri;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('incidenceMail');
    }
}
