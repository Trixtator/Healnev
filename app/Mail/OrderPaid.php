<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order; // Tambahkan use

class OrderPaid extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Buat properti publik

    public function __construct(Order $order)
    {
        $this->order = $order; // Terima data order
    }

    public function build()
    {
        return $this->subject('Invoice Pembayaran Anda - ' . $this->order->order_code)
                    ->markdown('emails.order-paid'); // Arahkan ke view email
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Paid',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
