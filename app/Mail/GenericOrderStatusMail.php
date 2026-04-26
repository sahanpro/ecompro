<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class GenericOrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $subjectLine, public string $templateKey, public ?Order $order)
    {
    }

    public function build(): self
    {
        return $this->subject($this->subjectLine)
            ->view('emails.generic-order-status')
            ->with(['template' => $this->templateKey, 'order' => $this->order]);
    }
}
