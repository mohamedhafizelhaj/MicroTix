<?php

use GRPC\Services\Event\EventService;
use GRPC\Services\Event\EventInterface;
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

$server->registerService(EventInterface::class, new EventService());

$server->serve(Worker::create());