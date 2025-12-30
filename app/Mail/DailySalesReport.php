<?php

namespace App\Mail;

use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailySalesReport extends Mailable
{
    use Queueable, SerializesModels;

    public $sales_data;
    public $report_date;
    public $admin_user;

    /**
     * Create a new message instance.
     */
    public function __construct($sales_data, Carbon $report_date, User $admin_user)
    {
        $this->sales_data = $sales_data;
        $this->report_date = $report_date;
        $this->admin_user = $admin_user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $date_formatted = $this->report_date->format('F j, Y');
        
        return new Envelope(
            subject: "Daily Sales Report - {$date_formatted}",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-sales-report',
            with: [
                'sales_data' => $this->sales_data,
                'report_date' => $this->report_date,
                'admin_user' => $this->admin_user,
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