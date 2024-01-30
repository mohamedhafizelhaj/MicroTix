<?php

namespace App\Jobs;

use App\Services\SendEmailsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendEventNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $operation;

    public $eventId;
    public $eventName;

    public $eventData;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->operation == 'update' 
            ? SendEmailsService::sendEventUpdatedMail($this->eventId, $this->eventName, $this->eventData)
            : SendEmailsService::sendEventDeletedMail($this->eventId, $this->eventName);
    }
}
