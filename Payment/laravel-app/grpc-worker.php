<?php

use GRPC\Services\Payment\PaymentService;
use GRPC\Services\Payment\PaymentInterface;
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

$server->registerService(PaymentInterface::class, new PaymentService());

$server->serve(Worker::create());