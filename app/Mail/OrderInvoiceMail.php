<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderInvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdfPath;

    public function __construct(Order $order, $pdfPath)
    {
        $this->order = $order;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Your Order Invoice #' . $this->order->order_number)
                    ->markdown('emails.invoice')
                    ->attach($this->pdfPath, [
                        'as' => 'Invoice-' . $this->order->id . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
