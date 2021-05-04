<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Http\Controllers\API\LoginController;
use App\Models\User;
use App\Support\ApiCodes;
use Illuminate\Foundation\Testing\RefreshDatabase;
use MarcinOrlowski\ResponseBuilder\Tests\Traits\TestingHelpers;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use TestingHelpers;
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    public function test_a_user_can_login()
    {
        $response = $this
            ->postJson(action([LoginController::class, 'store']), [
                'email' => $this->user->email,
                'password' => 'password',
            ]);

        $jsonResponse = json_decode($response->getContent(), false);

        $this->assertValidResponse($jsonResponse);

        $this->assertTrue($jsonResponse->success);

        $this->assertResponseStatusCode(ApiCodes::LOGIN_SUCCESS, $jsonResponse);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $response = $this->postJson(action([LoginController::class, 'store']), [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $jsonResponse = json_decode($response->getContent(), false);

        $this->assertValidResponse($jsonResponse);

        $this->assertFalse($jsonResponse->success);

        $this->assertResponseStatusCode(ApiCodes::EX_AUTHENTICATION_EXCEPTION(), $jsonResponse);
    }

    public function getApiCodesClassName(): string
    {
        return ApiCodes::class;
    }
}
