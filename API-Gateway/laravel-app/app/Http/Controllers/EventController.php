<?php

namespace App\Http\Controllers;

use GRPC\Clients\EventClient;
use GRPC\Clients\TicketClient;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\PayForEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\User;
use App\Traits\ResponseTrait;
use GRPC\Clients\PaymentClient;
use GRPC\Services\Event\AuthData;
use Illuminate\Support\Facades\Log;
use GRPC\Services\Event\EventData;
use GRPC\Services\Event\EventInstance;
use GRPC\Services\Event\EventId;
use GRPC\Services\Event\GetEventsRequest;
use GRPC\Services\Event\MyEventsRequest;
use GRPC\Services\Payment\PaymentInfo;
use GRPC\Services\Ticket\GetTicketRequest;
use Spiral\RoadRunner\GRPC\Context;

class EventController extends Controller
{
    use ResponseTrait;

    private $eventClient;
    private $paymentClient;
    private $ticketClient;

    public function __construct() {

        $this->eventClient = new EventClient('172.20.0.4:9001', [
            'credentials' => \Grpc\ChannelCredentials::createInsecure()
        ]);

        $this->paymentClient = new PaymentClient('172.20.0.6:9001', [
            'credentials' => \Grpc\ChannelCredentials::createInsecure()
        ]);

        $this->ticketClient = new TicketClient('172.20.0.5:9001', [
            'credentials' => \Grpc\ChannelCredentials::createInsecure()
        ]);
    }

    public function create(CreateEventRequest $request)
    {
        try {
            $eventData = new EventData([
                'name'         => $request->name,
                'organizer_id' => auth('sanctum')->id(),
                'description'  => $request->description,
                'startTime'    => $request->startTime,
                'endTime'      => $request->endTime,
                'address'      => $request->address,
                'ticketPrice'  => $request->ticketPrice,
                'discount'     => $request->discount
            ]);

            $event = $this->eventClient->createEvent(new Context([]), $eventData);
            return $this->response('event', $event);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }

    public function update(UpdateEventRequest $request)
    {
        try {
            $authData = new AuthData([
                'EventId' => $request->event_id,
                'OrganizerId' => auth('sanctum')->id()
            ]);

            $canUpdate = $this->eventClient->canPerformAction(new Context([]), $authData)->getSuccess();

            if (!$canUpdate)
                return $this->errorResponse('You are not allowed to perform this action', 401);

            $eventData = new EventData([
                'name'         => $request->name ?? "",
                'organizer_id' => auth('sanctum')->id(),
                'description'  => $request->description ?? "",
                'startTime'    => $request->startTime ?? "",
                'endTime'      => $request->endTime ?? "",
                'address'      => $request->address ?? "",
                'ticketPrice'  => $request->ticketPrice ?? "",
                'discount'     => $request->discount ?? ""
            ]);

            $eventInstance = new EventInstance([
                'id' => $request->event_id,
                'eventData' => $eventData
            ]);

            $event = $this->eventClient->updateEvent(new Context([]), $eventInstance);
            return $this->response('event', $event);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }

    public function delete($id)
    {
        try {
            $authData = new AuthData([
                'EventId' => $id,
                'OrganizerId' => auth('sanctum')->id()
            ]);

            $canDelete = $this->eventClient->canPerformAction(new Context([]), $authData)->getSuccess();

            if (!$canDelete)
                return $this->errorResponse('You are not allowed to perform this action', 401);

            $eventIdMessage = new EventId(['id' => $id]);
            $status = $this->eventClient->deleteEvent(new Context([]), $eventIdMessage);

            return response()->json(['success' => $status->getSuccess()]);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }

    public function myEvents()
    {
        try {
            $request = new MyEventsRequest([
                'user_id' => auth('sanctum')->id(),
                'page_token' => request()->query('page_token') ?? '',
                'page_size' => request()->query('page_size') ?? 10
            ]);

            $events = $this->eventClient->myEvents(new Context([]), $request);
            return $this->response('events', $events);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }

    public function getEvents()
    {
        try {
            $request = new GetEventsRequest([
                'page_token' => request()->query('page_token') ?? '',
                'page_size' => request()->query('page_size') ?? 10
            ]);

            $events = $this->eventClient->getEvents(new Context([]), $request);
            return $this->response('events', $events);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }

    public function getEvent($id)
    {
        try {
            $eventIdMessage = new EventId(['id' => $id]);

            $event = $this->eventClient->getEvent(new Context([]), $eventIdMessage);
            return $this->response('event', $event);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }

    public function payForEvent(PayForEventRequest $request)
    {
        try {
            $paymentInfo = new PaymentInfo([
                'customer_id' => auth('sanctum')->id(),
                'event_id' => $request->event_id,
                'email' => $request->email,
                'card' => $request->card,
                'exp_month' => $request->exp_month,
                'exp_year' => $request->exp_year,
                'cvv' => $request->cvv,
            ]);

            $status = $this->paymentClient->pay(new Context([]), $paymentInfo);
            return response()->json(['success' => $status->getSuccess()]);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }    
    }

    public function getTicket($id) {

        try {
            $request = new GetTicketRequest([
                'customer_id' => auth('sanctum')->id(),
                'event_id' => $id,
                'email' => User::find(auth('sanctum')->id())->email
            ]);

            $ticketData = $this->ticketClient->getTicket(new Context([]), $request);
            return $this->response('ticket', $ticketData);

        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json(['success' => false, 'error' => 'Server Error']);
        }
    }
}
