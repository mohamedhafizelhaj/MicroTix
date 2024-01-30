<?php

namespace GRPC\Services\Event;

use App\Jobs\SendEventNotifications;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spiral\RoadRunner\GRPC\ContextInterface;

class EventService implements EventInterface
{
    public function createEvent(ContextInterface $ctx, EventData $in): EventInstance
    {
        DB::beginTransaction();
        try {
            $eventData = [
                'name' => $in->getName(),
                'organizer_id' => $in->getOrganizerId(),
                'description' => $in->getDescription(),
                'startTime' => $in->getStartTime(),
                'endTime' => $in->getEndTime(),
                'address' => $in->getAddress(),
                'ticketPrice' => $in->getTicketPrice(),
                'discount' => $in->getDiscount()
            ];
    
            $createdEvent = Event::create($eventData);
            DB::commit();
    
            return new EventInstance([
                'id' => $createdEvent->id,
                'eventData' => new EventData($eventData)
            ]);

        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            throw new \Exception($th);
        }
    }

    public function updateEvent(ContextInterface $ctx, EventInstance $in): EventInstance
    {
        DB::beginTransaction();
        try {
            $eventId   = $in->getId();
            $eventData = $in->getEventData();

            $event = Event::find($eventId);
            $oldName = $event->name;

            $name         = $eventData->getName() != "" ? $eventData->getName() : $event->name;
            $organizer_id = $event->organizer_id;
            $description  = $eventData->getDescription() != "" ? $eventData->getDescription() : $event->description;
            $startTime    = $eventData->getStartTime() != "" ? Carbon::parse($eventData->getStartTime())->toDateString() : Carbon::parse($event->startTime)->toDateString();
            $endTime      = $eventData->getEndTime() != "" ? Carbon::parse($eventData->getEndTime())->toDateString() : Carbon::parse($event->endTime)->toDateString();
            $address      = $eventData->getAddress() != "" ? $eventData->getAddress() : $event->address;
            $ticketPrice  = $eventData->getTicketPrice() != "" ? $eventData->getTicketPrice() : $event->ticketPrice;
            $discount     = $eventData->getDiscount() != "" ? $eventData->getDiscount() : $event->discount;

            $eventData = [
                'name'         => $name,
                'organizer_id' => $organizer_id,
                'description'  => $description,
                'startTime'    => $startTime,
                'endTime'      => $endTime,
                'address'      => $address,
                'ticketPrice'  => $ticketPrice,
                'discount'     => $discount
            ];

            $event->update($eventData);

            DB::commit();

            // notify users that pay a ticket for this event about the update
            $this->notifyNotificationService('update', $eventId, $oldName, $eventData);

            // return the grpc response
            return new EventInstance([
                'id' => $eventId,
                'eventData' => new EventData($eventData)
            ]);

        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            throw new \Exception($th);
        }
    }

    public function deleteEvent(ContextInterface $ctx, EventId $in): Status
    {
        DB::beginTransaction();
        try {
            $eventId = $in->getId();
            $event = Event::find($in->getId());

            $eventName = $event->name;
            $event->delete();

            DB::commit();

            // notify users that pay a ticket for this event, that the event has been canelled
            // and that they will get a refund
            $this->notifyNotificationService('delete', $eventId, $eventName);
            return new Status(['success' => true]);

        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();

            throw new \Exception($th);
        }
    }

    public function notifyNotificationService($operation, $eventId, $eventName, $eventData = null)
    {
        dispatch(new SendEventNotifications($operation, $eventId, $eventName, $eventData));
    }

    public function myEvents(ContextInterface $ctx, MyEventsRequest $in): PaginatedEventsResponse
    {
        try {
            $pageSize  = $in->getPageSize();
            $pageToken = $in->getPageToken();

            $eventsQuery = Event::where('organizer_id', $in->getUserId());
            return $this->paginateEvents($pageSize, $pageToken, $eventsQuery);

        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception($th);
        }
    }

    public function getEvents(ContextInterface $ctx, GetEventsRequest $in): PaginatedEventsResponse
    {
        $pageSize  = $in->getPageSize();
        $pageToken = $in->getPageToken();

        $eventsQuery = Event::query();
        return $this->paginateEvents($pageSize, $pageToken, $eventsQuery);
    }

    public function paginateEvents($pageSize, $pageToken, $eventsQuery): PaginatedEventsResponse
    {
        if ($pageToken != '')
            $eventsQuery->where('id', '>', $pageToken);

        $events = $eventsQuery->take($pageSize)->get()->toArray();

        $response = new PaginatedEventsResponse();

        $eventInstances = [];
        foreach ($events as $event) {
            $eventInstance = new EventInstance();

            $eventInstance->setId($event['id']);
            $eventInstance->setEventData(new EventData([
                'name'         => $event['name'],
                'organizer_id' => $event['organizer_id'],
                'description'  => $event['description'],
                'startTime'    => $event['startTime'],
                'endTime'      => $event['endTime'],
                'address'      => $event['address'],
                'ticketPrice'  => $event['ticketPrice'],
                'discount'     => $event['discount']
            ]));

            array_push($eventInstances, $eventInstance);
        }

        $response->setEvents($eventInstances);

        $nextPageToken = '';

        $lastId = end($events)['id'];
        if (Event::where('id', '>', $lastId)->count() > 0)
            $nextPageToken = $lastId;

        $response->setNextPageToken($nextPageToken);
        return $response;
    }

    public function getEvent(ContextInterface $ctx, EventId $in): EventInstance
    {
        try {
            $event = Event::find($in->getId());

            $eventInstance = new EventInstance([
                'id' => $event->id,
                'eventData' => new EventData([
                    'name'         => $event->name,
                    'organizer_id' => $event->organizer_id,
                    'description'  => $event->description,
                    'startTime'    => (string) $event->startTime,
                    'endTime'      => (string) $event->endTime,
                    'address'      => $event->address,
                    'ticketPrice'  => $event->ticketPrice,
                    'discount'     => $event->discount,
                ])
            ]);

            return $eventInstance;

        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception($th);
        }
    }

    public function canPerformAction(ContextInterface $ctx, AuthData $in): Status
    {
        try {
            $eventId = $in->getEventId();
            $event = Event::find($eventId);

            return new Status(['success' => $event->organizer_id == $in->getOrganizerId()]);

        } catch (\Throwable $th) {
            Log::error($th);
            throw new \Exception($th);
        }
    }
}