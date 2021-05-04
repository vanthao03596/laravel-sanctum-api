<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\API\RegisterController;
use App\Support\ApiCodes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MarcinOrlowski\ResponseBuilder\Tests\Traits\TestingHelpers;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use TestingHelpers;
    use RefreshDatabase;

    public function test_new_users_can_register()
    {
        $response = $this->postJson(action(RegisterController::class), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'validPassword@2021',
            'password_confirmation' => 'validPassword@2021',
            'terms' => '1',
        ]);

        $jsonResponse = json_decode($response->getContent(), false);

        $this->assertValidResponse($jsonResponse);

        $this->assertTrue($jsonResponse->success);

        $this->assertResponseStatusCode(ApiCodes::REGISTER_SUCCESS, $jsonResponse);

        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function getApiCodesClassName(): string
    {
        return ApiCodes::class;
    }
}
