<?php
namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class AppointmentReminderMail extends Mailable implements ShouldQueue
{
    use \Illuminate\Bus\Queueable;
    public $childName;
    public $doctorName;
    public $appointmentDate;

    public function __construct($childName, $doctorName, $appointmentDate)
    {
        $this->childName = $childName;
        $this->doctorName = $doctorName;
        $this->appointmentDate = $appointmentDate;
    }

    public function build()
    {
        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
                    ->subject('Appointment Reminder')
                    ->view('emails.appointment_reminder')
                    ->with([
                        'childName' => $this->childName,
                        'doctorName' => $this->doctorName,
                        'appointmentDate' => $this->appointmentDate
                    ]);
    }
}
