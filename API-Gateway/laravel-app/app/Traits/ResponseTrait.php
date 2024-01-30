<?php

namespace App\Traits;

use App\Http\Resources\UserResource;
use App\Models\User;

trait ResponseTrait
{
    public function response($instanceType, $instance)
    {
        switch ($instanceType) {
            case 'event':
                $eventResponse = $this->generateEventResponse($instance);
                return $this->successResponse($eventResponse);

                break;
            
            case 'events':
                $eventsResponse = $this->generateEventsResponse($instance);
                return $this->successResponse($eventsResponse);
                
                break;

            case 'ticket':
                $ticketResponse = $this->generateTicketResponse($instance);
                return $this->successResponse($ticketResponse);
        }
    }

    public function generateEventResponse($event)
    {
        $data = $event->getEventData();

        return [
            'id' => $event->getId(),
            'name' => $data->getName(),
            'organizer' => $data->getOrganizerId() ? new UserResource(User::find($data->getOrganizerId())) : null,
            'description' => $data->getDescription(),
            'startTime' => $data->getStartTime(),
            'endTime' => $data->getEndTime(),
            'address' => $data->getAddress(),
            'ticketPrice' => $data->getTicketPrice(),
            'discount' => $data->getDiscount()
        ];
    }

    public function generateEventsResponse($events)
    {
        $eventsArray = [];

        foreach ($events->getEvents() as $event)
        {
            $data = $event->getEventData();

            array_push($eventsArray, [
                'id' => $event->getId(),
                'name' => $data->getName(),
                'organizer' => new UserResource(User::find($data->getOrganizerId())),
                'description' => $data->getDescription(),
                'startTime' => $data->getStartTime(),
                'endTime' => $data->getEndTime(),
                'address' => $data->getAddress(),
                'ticketPrice' => $data->getTicketPrice(),
                'discount' => $data->getDiscount()
            ]);
        }

        $response = [
            'data' => $eventsArray,
            'next_page_token' => $events->getNextPageToken(),
            'last_page' => $events->getNextPageToken() == ""
        ];

        return $response;
    }

    public function generateTicketResponse($ticket)
    {
        return [
            'id' => $ticket->getId(),
            'code' => $ticket->getCode()
        ];
    }

    public function successResponse($data)
    {
        return response()->json(['success' => true, 'data' => $data]);
    }

    public function errorResponse($error, $code)
    {
        return response()->json(['success' => false, 'error' => $error], $code);
    }
}