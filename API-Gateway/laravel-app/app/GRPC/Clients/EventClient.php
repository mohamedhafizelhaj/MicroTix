<?php

namespace GRPC\Clients;

use GRPC\Services\Event\EventInterface;
use Grpc\BaseStub;
use GRPC\Services\Event\AuthData;
use Illuminate\Support\Facades\Log;
use Spiral\RoadRunner\GRPC\ContextInterface;
use GRPC\Services\Event\EventData;
use GRPC\Services\Event\EventId;
use GRPC\Services\Event\EventInstance;
use GRPC\Services\Event\Nothing;
use GRPC\Services\Event\Events;
use GRPC\Services\Event\GetEventsRequest;
use GRPC\Services\Event\MyEventsRequest;
use GRPC\Services\Event\PaginatedEventsResponse;
use GRPC\Services\Event\Status;
use GRPC\Services\Event\UserId;
use Spiral\RoadRunner\GRPC\StatusCode;

class EventClient extends BaseStub implements EventInterface
{
    function createEvent(ContextInterface $ctx, EventData $in): EventInstance
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/createEvent',
            $in,
            [EventInstance::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('GRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }

    function updateEvent(ContextInterface $ctx, EventInstance $in): EventInstance
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/updateEvent',
            $in,
            [EventInstance::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('GRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }

    function deleteEvent(ContextInterface $ctx, EventId $in): Status
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/deleteEvent',
            $in,
            [Status::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('GRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }

    public function myEvents(ContextInterface $ctx, MyEventsRequest $in): PaginatedEventsResponse
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/myEvents',
            $in,
            [PaginatedEventsResponse::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('GRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }

    public function getEvents(ContextInterface $ctx, GetEventsRequest $in): PaginatedEventsResponse
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/getEvents',
            $in,
            [PaginatedEventsResponse::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('GRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }

    function getEvent(ContextInterface $ctx, EventId $in): EventInstance
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/getEvent',
            $in,
            [EventInstance::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('GRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;
    }

    function canPerformAction(ContextInterface $ctx, AuthData $in): Status
    {
        [$response, $status] = $this->_simpleRequest(
            '/' . self::NAME . '/canPerformAction',
            $in,
            [Status::class, 'decode']
        )->wait();

        if ($status->code !== StatusCode::OK) {
            Log::error('GRPC error: ' . $status->details);
            throw new \Exception($status->details);
        }
        
        return $response;   
    }
}