<?php

namespace App\Http\Controllers\API;

use function abort;
use App\Http\Requests\API\UserLoginRequest;
use App\Models\User;
use App\Services\TokenManager;
use App\Support\ApiCodes;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

final class LoginController
{
    public function __construct(
        private TokenManager $tokenManager,
    ) {
    }

    public function store(UserLoginRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        /** @var User|null $user */
        $user = User::firstWhere('email', $request->email);

        if (! $user || ! Hash::check($request->password, $user->password)) {
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
        $this->tokenManager->destroyTokens(Auth::user());

        return ResponseBuilder::asSuccess(ApiCodes::LOGOUT_SUCCESS)
            ->build();
    }
}
