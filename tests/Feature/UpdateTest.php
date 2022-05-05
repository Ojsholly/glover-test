<?php

namespace Tests\Feature;

use App\Models\Update;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateTest extends TestCase
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

    public function testUpdateListAuthorization()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->json("GET", 'api/v1/admins/updates', [], ['Accept' => 'application/json'])
        ->assertStatus(403)
        ->assertJsonStructure([
            "status",
            "message"
        ]);
    }

    public function testPendingUpdateList()
    {
        Sanctum::actingAs(
            User::role('admin')->get()->random(),
            ['*']
        );

        $this->json("GET", 'api/v1/admins/updates', [], ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data"
            ]);
    }

    public function testUpdateCreationAuthorization()
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $this->json("POST", 'api/v1/admins/updates', [], ['Accept' => 'application/json'])
            ->assertStatus(403);
    }

    public function testRequiredFieldsForUpdateCreation()
    {
        Sanctum::actingAs(
            User::role('admin')->get()->random(),
            ['*']
        );

        $this->json("POST", 'api/v1/admins/updates', [], ['Accept' => 'application/json'])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['user_id', 'requested_by', 'type', 'details']);
    }

    public function testUpdateCreation()
    {
        Sanctum::actingAs(
            User::role('admin')->get()->random(),
            ['*']
        );

        $updateTypes = [Update::CREATE, Update::UPDATE, Update::DELETE];

        $user = User::role('user')->get()->random();
        $admin = User::role('admin')->get()->random();
        $count = count($updateTypes);


        $data = [
          'user_id' => $user->uuid,
            'requested_by' => $admin->uuid,
            'type' => $updateTypes[mt_rand(0, $count - 1)],
            'details' => $user->only(['first_name', 'last_name', 'email'])
        ];

        $this->json("POST", 'api/v1/admins/updates', $data, ['Accept' => 'application/json'])
                ->assertStatus(201)
                ->assertJsonStructure([
                    "status",
                    "message",
                    "data" => [
                        "id",
                        "uuid",
                        "user",
                        "requested_by",
                        "type",
                        "details",
                        "confirmed_at",
                        "created_at",
                        "updated_at"
                    ]
                ]);
    }
}
