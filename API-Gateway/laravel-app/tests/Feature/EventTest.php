<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Junges\Kafka\Facades\Kafka;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_organizer_can_create_event() {

        Kafka::fake();

        $organizer = User::factory()->create(['role' => 'Organizer']);

        $eventData = [
            'name'         => 'Test event name',
            'description'  => 'Test event description',
            'startTime'    => '10-10-2024 08:00',
            'endTime'      => '17-10-2024 17:00',
            'address'      => 'Test address',
            'tricketPrice' => '$200',
            'discount'     => '10%'
        ];

        Sanctum::actingAs($organizer);

        $response = $this->postJson('/api/event', $eventData);
        $response->assertOk();

        Kafka::assertPublishedOn('event-management');
    }

    public function test_an_organizer_can_update_event() {

        Kafka::fake();

        $organizer = User::factory()->create(['role' => 'Organizer']);

        $eventData = [
            'event_id'     => 1,
            'startTime'    => '10-10-2024 08:00',
            'endTime'      => '24-10-2024 17:00',
        ];

        Sanctum::actingAs($organizer);

        $response = $this->patchJson('/api/event', $eventData);
        $response->assertOk();

        Kafka::assertPublishedOn('event-management');
    }

    public function test_an_organizer_can_delete_event() {

        Kafka::fake();

        $organizer = User::factory()->create(['role' => 'Organizer']);

        Sanctum::actingAs($organizer);

        $response = $this->deleteJson('/api/event/1');
        $response->assertOk();

        Kafka::assertPublishedOn('event-management');
    }

    public function test_users_can_get_events_list() {

        Kafka::fake();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/event');
        $response->assertOk();

        Kafka::assertPublishedOn('event-management');
    }

    public function test_users_can_get_specific_event() {
        
        Kafka::fake();

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/event/1');
        $response->assertOk();

        Kafka::assertPublishedOn('event-management');
    }

    public function test_clients_can_get_event_ticket() {
        
        Kafka::fake();

        $client = User::factory()->create(['role' => 'Client']);

        Sanctum::actingAs($client);

        $response = $this->postJson('/api/event/1/ticket');
        $response->assertOk();

        Kafka::assertPublishedOn('ticketing');
    }
}
