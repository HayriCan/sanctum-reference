<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    public function testApiTokenForSendingInvitation()
    {
        $this->json('POST', 'api/send-invitation', ['Accept' => 'application/json'])
            ->assertStatus(401)
            ->assertJson([
                "message" => "Unauthenticated.",
            ]);
    }

    public function testRequiredFieldsForSendingInvitation()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $this->json('POST', 'api/send-invitation', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "error" => true,
                "message" => "InvitationRequest validation failed",
                "data" => [
                    "email" => ["The email field is required."],
                ]
            ]);
    }

    public function testSuccessfulSendingInvitation()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');

        $userData = [
            "email" => "doe@example.com",
        ];

        $this->json('POST', 'api/send-invitation', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "error" => false,
                "message" => "Invitation Mail Has Been Sent",
                "data" => null
            ]);
    }

}
