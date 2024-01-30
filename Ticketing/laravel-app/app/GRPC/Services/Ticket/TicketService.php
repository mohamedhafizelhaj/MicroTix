<?php

namespace GRPC\Services\Ticket;

use App\Models\Ticket;
use GRPC\Clients\PaymentClient;
use GRPC\Services\Payment\PaymentId;
use Illuminate\Support\Facades\Log;
use Spiral\RoadRunner\GRPC\Context;
use Spiral\RoadRunner\GRPC\ContextInterface;

class TicketService implements TicketInterface
{
    function getTicket(ContextInterface $ctx, GetTicketRequest $in): TicketData
    {
        try {
            // check if the event had been payed for by the customer
            $paymentClient = new PaymentClient('172.20.0.6:9001', [
                'credentials' => \Grpc\ChannelCredentials::createInsecure()
            ]);

            $paymentId = new PaymentId([
                'email' => $in->getEmail(),
                'event_id' => $in->getEventId()
            ]);

            $status = $paymentClient->checkStatus(new Context([]), $paymentId);

            if (!$status->getSuccess())
                throw new \Exception('event is not payed for');

            $code = bin2hex(random_bytes(3));

            while (Ticket::where('code', $code)->exists())
                $code = bin2hex(random_bytes(3));

            $ticket = Ticket::create([
                'customer_id' => $in->getCustomerId(),
                'event_id' => $in->getEventId(),
                'code' => $code
            ]);

            return new TicketData([
                'id' => $ticket->id,
                'code' => $code
            ]);

        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception($th);
        }
    }
}