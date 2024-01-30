<?php

namespace Grpc\Clients;

use Grpc\BaseStub;
use GRPC\Services\Payment\PaymentId;
use GRPC\Services\Payment\PaymentInterface;
use Spiral\RoadRunner\GRPC\ContextInterface;
use GRPC\Services\Payment\Status;
use Illuminate\Support\Facades\Log;
use Spiral\RoadRunner\GRPC\StatusCode;

class PaymentClient extends BaseStub implements PaymentInterface
{
    function checkStatus(ContextInterface $ctx, PaymentId $in): Status
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/checkStatus',
            $in,
            [Status::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('gRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }
}