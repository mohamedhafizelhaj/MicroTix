<?php

namespace App\Services;

use App\Mail\EventDeletedMail;
use App\Mail\EventUpdatedMail;
use App\Models\Email;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailsService
{
    public static function sendEventUpdatedMail($eventId, $eventName, $eventData)
    {
        try {
            // get list of users' emails who paid for this event
            $emails = Email::where('event_id', $eventId)->pluck('email');

            foreach ($emails as $email)
                Mail::to($email)->send(new EventUpdatedMail($eventName, $eventData));

        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public static function sendEventDeletedMail($eventId, $eventName)
    {
        try {
            // get list of users' emails who paid for this event
            $emails = Email::where('event_id', $eventId)->pluck('email');

            foreach ($emails as $email)
                Mail::to($email)->send(new EventDeletedMail($eventName));

        } catch (\Throwable $th) {
            Log::error($th);
        }
    }
}