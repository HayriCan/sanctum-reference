<?php

namespace Tests\Feature;

use App\Models\ReferenceCode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use WithFaker;

    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/auth/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "error" => true,
                "message" => "StoreUserRequest validation failed",
                "data" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testRepeatPassword()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345"
        ];

        $this->json('POST', 'api/auth/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "error" => true,
                "message" => "StoreUserRequest validation failed",
                "data" => [
                    "password" => ["The password confirmation does not match."],
                ]
            ]);
    }

    public function testInvalidReferenceNumber()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345",
            "ref_code" => "refcode"

        ];

        $this->json('POST', 'api/auth/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(400)
            ->assertJson([
                "error" => true,
                "message" => "Reference number not found",
                "data" => null
            ]);
    }

    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345"
        ];

        $this->json('POST', 'api/auth/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "message",
                "data" => [
                    "token",
                    "user" => [
                        'name',
                        'email',
                        'created_at'
                    ],
                    "wallet" => [
                        'amount',
                        'currency'
                    ]
                ],
            ]);
    }

    public function testSuccessfulRegistrationWithRefCode()
    {
        $user = User::factory()->state([
            'password' => 'sample123'
        ])->create();

        $ref_code = ReferenceCode::factory()->create([
            'referrer_id' => $user->id
        ]);

        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345",
            "ref_code" => $ref_code->code
        ];

        $this->json('POST', 'api/auth/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "message",
                "data" => [
                    "token",
                    "user" => [
                        'name',
                        'email',
                        'created_at'
                    ],
                    "wallet" => [
                        'amount',
                        'currency'
                    ]
                ],
            ]);
    }

    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/auth/login')
            ->assertStatus(422)
            ->assertJson([
                "error" => true,
                "message" => "StoreUserRequest validation failed",
                "data" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = User::factory()->state([
            'password' => 'sample123'
        ])->create();

        $loginData = ['email' => $user->email, 'password' => 'sample123'];
        $this->json('POST', 'api/auth/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "message",
                "data" => [
                    "token",
                    "user" => [
                        'name',
                        'email',
                        'created_at'
                    ],
                    "wallet" => [
                        'amount',
                        'currency'
                    ]
                ],
            ]);

        $this->assertAuthenticated();
    }
}
