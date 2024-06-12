<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use App\Models\Budget;

class PartiallySpent extends Mailable
{
    use Queueable, SerializesModels;

    public $budget;
    public $transactions;

    /**
     * Create a new message instance.
     */
    public function __construct(Budget $budget, $transactions)
    {
        $this->budget = $budget;
        $this->transactions = $transactions;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('expense@example.com', 'Expense Tracker'),
            subject: 'Your budget limit is almost reached',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.partial',
            with: [
                'budgetName' => $this->budget->name,
                'budgetCategory' => $this->budget->categories->first()->name, // Assuming a single category for simplicity
                'budgetAmount' => $this->budget->amount,
                'transactions' => $this->transactions,
            ]
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
