<?php

namespace GRPC\Clients;

use Google\Protobuf\GPBEmpty;
use Grpc\BaseStub;
use GRPC\Services\Notification\NotificationInterface;
use Spiral\RoadRunner\GRPC\ContextInterface;
use GRPC\Services\Notification\TransactionData;

class NotificationClient extends BaseStub implements NotificationInterface
{
    public function addTransaction(ContextInterface $ctx, TransactionData $in): GPBEmpty
    {
        $this->_simpleRequest(
            '/' . self::NAME . '/addTransaction',
            $in,
            [GPBEmpty::class, 'decode']
        );

        return new GPBEmpty();   
    }
}