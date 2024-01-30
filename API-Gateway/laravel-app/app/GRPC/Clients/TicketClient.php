<?php

namespace Grpc\Clients;

use Grpc\BaseStub;
use Illuminate\Support\Facades\Log;
use GRPC\Services\Ticket\GetTicketRequest;
use GRPC\Services\Ticket\TicketData;
use GRPC\Services\Ticket\TicketInterface;
use Spiral\RoadRunner\GRPC\ContextInterface;
use Spiral\RoadRunner\GRPC\StatusCode;

class TicketClient extends BaseStub implements TicketInterface
{
    function getTicket(ContextInterface $ctx, GetTicketRequest $in): TicketData
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/getTicket',
            $in,
            [TicketData::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('gRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }
}