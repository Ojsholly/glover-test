<?php

namespace Tests\Feature;

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
}
