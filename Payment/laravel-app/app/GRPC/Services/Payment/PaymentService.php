<?php

namespace GRPC\Services\Payment;

use App\Models\Transaction;
use GRPC\Clients\NotificationClient;
use GRPC\Services\Notification\TransactionData;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spiral\RoadRunner\GRPC\Context;
use Spiral\RoadRunner\GRPC\ContextInterface;

class PaymentService implements PaymentInterface
{
    public function pay(ContextInterface $ctx, PaymentInfo $in): Status
    {
        DB::beginTransaction();
        try {
            // here we are simulating a payment with a 90% success rate.
            $success = mt_rand(1, 10) < 9;

            Transaction::create([
                'event_id' => $in->getEventId(),
                'email' => $in->getEmail(),
                'success' => $success
            ]);

            DB::commit();

            if ($success) {

                // notify the notifications service, so it can update
                // the list of emails who successfully payed for
                // this particular event, in order to send them
                // notification about any news regarding it.

                $this->notifyNotificationService($in);
            }

            return new Status(['success' => $success]);

        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            
            throw new \Exception($th);
        }
    }

    public function checkStatus(ContextInterface $ctx, PaymentId $in): Status
    {
        $email = $in->getEmail();
        $eventId = $in->getEventId();

        $transaction = Transaction::where('email', $email)
                        ->where('event_id', $eventId)->first();

        $status = $transaction && $transaction->success;
        return new Status(['success' => $status]);
    }

    public function notifyNotificationService($payload)
    {
        $transactionData = new TransactionData([
            'event_id' => $payload->getEventId(),
            'email' => $payload->getEmail()
        ]);

        $notificationClient = new NotificationClient('172.20.0.7:9001', [
            'credentials' => \Grpc\ChannelCredentials::createInsecure()
        ]);
        $notificationClient->addTransaction(new Context([]), $transactionData);
    }
}