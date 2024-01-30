<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

    <b><p>Event {{ $oldName }} Has been updated.</p></b>

    <br>

    <b><p>Event Details: </p></b>
    
    <p>Event name: {{ $eventData['name'] }}.</p>
    <p>Event description: {{ $eventData['description'] }}.</p>
    <p>Event start time: {{ $eventData['startTime'] }}.</p>
    <p>Event end time: {{ $eventData['endTime'] }}.</p>
    <p>Address: {{ $eventData['address'] }}.</p>
    <p>Ticket price: {{ $eventData['ticketPrice'] }}.</p>
    <p>Discount: {{ $eventData['discount'] }}.</p>
    
</body>
</html>