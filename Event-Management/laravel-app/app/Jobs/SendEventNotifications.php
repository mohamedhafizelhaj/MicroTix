<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
    public function __construct($operation, $eventId, $eventName, $eventData = null)
    {
        $this->operation = $operation;
        $this->eventId   = $eventId;
        $this->eventName = $eventName;
        $this->eventData = $eventData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
