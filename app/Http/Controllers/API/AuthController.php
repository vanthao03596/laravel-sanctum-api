<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\UserLoginRequest;
use App\Models\User;
use App\Services\TokenManager;
use App\Support\ApiCodes;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Hashing\HashManager;
use Illuminate\Http\Response;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use function abort;

final class AuthController
{
    public function __construct
    (
        private HashManager $hash,
        private ?Authenticatable $currentUser,
        private TokenManager $tokenManager,
    )
    {
    }

    public function store(UserLoginRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        /** @var User|null $user */
        $user = User::firstWhere('email', $request->email);

        if (!$user || !$this->hash->check($request->password, $user->password)) {
            abort(Response::HTTP_UNAUTHORIZED);
        }

        return ResponseBuilder::asSuccess(ApiCodes::LOGIN_SUCCESS)
            ->withData([
                'token' => $this->tokenManager->createToken($user)->plainTextToken,
            ])
            ->build();
    }

    public function destroy(): \Symfony\Component\HttpFoundation\Response
    {
        $this->tokenManager->destroyTokens($this->currentUser);

        return ResponseBuilder::asSuccess(ApiCodes::LOGOUT_SUCCESS)
            ->build();
    }
}
