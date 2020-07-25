<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ApiTest extends TestCase
{
    use WithFaker;

    public function testApiServerIsUp()
    {
        $response = $this->get('https://dev.api.customerpay.me');

        $response->assertStatus(200);
    }

    public function testuserCanRegisterWithTheApi() {
        $response = $this->post('https://dev.api.customerpay.me/register/user', [
            'phone_number' => $this->faker->phoneNumber,
            'password' => 'password'
        ],
    [
        'Content-Type' => 'application/x-www-form-urlencoded'
    ]);

        $response->assertSuccessful();
    }
}
