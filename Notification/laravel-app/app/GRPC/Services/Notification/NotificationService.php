<?php

namespace GRPC\Services\Notification;

use App\Models\Email;
use Exception;
use Google\Protobuf\GPBEmpty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spiral\RoadRunner\GRPC\ContextInterface;

class NotificationService implements NotificationInterface
{
    public function addTransaction(ContextInterface $ctx, TransactionData $in): GPBEmpty
    {
        DB::beginTransaction();
        try {
            $eventId  = $in->getEventId();
            $email    = $in->getEmail();

            if (!Email::where('event_id', $eventId)->where('email', $email)->exists())
            {
                Email::create([
                    'event_id' => $eventId,
                    'email' => $email
                ]);
            }

            DB::commit();
            return new GPBEmpty();

        } catch (\Throwable $th) {
            throw new Exception($th);
            Log::error($th);
        }
    }
}