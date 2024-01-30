<?php

namespace Grpc\Clients;

use Grpc\BaseStub;
use GRPC\Services\Payment\PaymentInfo;
use GRPC\Services\Payment\PaymentInterface;
use Spiral\RoadRunner\GRPC\ContextInterface;
use GRPC\Services\Payment\Status;
use Spiral\RoadRunner\GRPC\StatusCode;

class PaymentClient extends BaseStub implements PaymentInterface
{
    function pay(ContextInterface $ctx, PaymentInfo $in): Status
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/pay',
            $in,
            [Status::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            throw new \Exception($status->details);
        }
        
        return $response;
    }
}