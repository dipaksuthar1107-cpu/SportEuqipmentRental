<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $studentName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $studentName)
    {
        $this->booking = $booking;
        $this->studentName = $studentName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Booking Approved - Sports Rental')
                    ->view('emails.booking_approved');
    }
}
