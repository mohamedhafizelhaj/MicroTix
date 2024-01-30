<?php

use GRPC\Services\Ticket\TicketService;
use GRPC\Services\Ticket\TicketInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$server = new Server(
    options: [
        'debug' => false,
    ]
);

$server->registerService(TicketInterface::class, new TicketService());

$server->serve(Worker::create());