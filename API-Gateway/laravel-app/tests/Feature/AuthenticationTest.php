<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register() {

        $data = [
            'fullname' => fake()->userName(),
            'email' => fake()->unique()->email(),
            'password' => fake()->password(),
            'role' => 'Customer',
        ];

        $response = $this->postJson('/api/auth/register', $data);

        $response->assertStatus(201)
                ->assertJsonFragment([
                    'success' => true
                ]);

        $this->assertDatabaseHas('users', [
            'phone' => $data['phone'],
            'role'  => 'Customer'
        ]);
    }

    public function test_user_can_not_register_with_invalid_data() {

        $data = [
            'fullname' => fake()->userName(),
            'email' => 'wrongmail',
            'password' => fake()->password(5, 5),
            'role' => 'Customer'
        ];

        $response = $this->postJson('/api/user/create', $data);
        $response->assertStatus(422)
                ->assertJsonValidationErrorFor('email')
                ->assertJsonValidationErrorFor('password');
        
        $this->assertDatabaseMissing('users', [
            'email' => $data['email']
        ]);
    }

    public function test_user_can_login() {

        $user = User::factory()->create();

        $response = $this->postJson('/api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk();
        $response->assertJsonStructure([
            'success',
            'token'
        ]);

        $response->assertJsonFragment([
            'success' => true
        ]);
    }
}
