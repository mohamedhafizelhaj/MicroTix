<?php

use GRPC\Services\Notification\NotificationService;
use GRPC\Services\Notification\NotificationInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$server = new Server(
    options: [
        'debug' => true,
    ]
);

$server->registerService(NotificationInterface::class, new NotificationService());

$server->serve(Worker::create());