<?php
namespace App\Mail;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentReminderMail extends Mailable implements ShouldQueue
{
    use \Illuminate\Bus\Queueable, SerializesModels;
    public $childName;
    public $doctorName;
    public $appointmentDate;

    public function __construct($childName, $doctorName, $appointmentDate)
    {
        $this->childName = $childName;
        $this->doctorName = $doctorName;
        $this->appointmentDate = Carbon::parse($appointmentDate)->toFormattedDayDateString();
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('no-reply@beaconcenter.com', 'Beacon Children Center'),
            subject: 'Beacon Children Center - Appointment Reminder',
        );
    }


    public function content():Content
    {
        return new Content(
            view: 'emails.appointment_reminder',
            with: [
                'childName' => $this->childName,
                'doctorName' => $this->doctorName,
                'appointmentDate' => $this->appointmentDate,
            ]
        );
    }

}
