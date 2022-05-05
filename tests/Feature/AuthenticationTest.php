<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRequiredFieldsForAdminRegistration()
    {
        $this->json('POST', 'api/v1/admins', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password']);
    }

    public function testRepeatPassword()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/v1/admins', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['password']);
    }

    public function testSuccessfulAdminRegistration()
    {
        $userData = [
            "first_name" => "John",
            "last_name" => "Doe",
            "email" => Str::random(10)."doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345"
        ];

        $this->json('POST', 'api/v1/admins', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "id",
                    "uuid",
                    "first_name",
                    "last_name",
                    'reference',
                    "email",
                    "email_verified_at",
                    "created_at",
                    "updated_at"
                ]
            ]);
    }

    public function testRequiredFieldsForAdminLogin()
    {
        $this->json("POST", 'api/v1/admins/login', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function testAdminLogin()
    {
        $user = User::factory()->create();

        $credentials = ['email' => $user->email, 'password' => 'password'];

        $this->json("POST", "api/v1/admins/login", $credentials, ['Accept' => 'application/json'])
                ->assertStatus(200)
                ->assertJsonStructure([
                    "status",
                    "message",
                    "data" => [
                        "token",
                        "user" => [
                            "id",
                            "uuid",
                            "first_name",
                            "last_name",
                            "email",
                            "email_verified_at",
                            "created_at",
                            "updated_at"
                        ]
                    ]
                ]);
    }

    public function testLogOut()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->json("POST", 'api/v1/admins/logout', [], ['Accept' => 'application/json'])
                ->assertStatus(200)
                ->assertJsonStructure([
                    "status",
                    "message",
                    "data"
                ]);
    }
}
