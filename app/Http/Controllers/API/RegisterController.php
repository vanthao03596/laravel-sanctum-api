<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\UserRegisterRequest;
use App\Models\User;
use App\Support\ApiCodes;
use Illuminate\Support\Facades\Hash;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;

class RegisterController
{

    public function __invoke(UserRegisterRequest $request): \Symfony\Component\HttpFoundation\Response
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return ResponseBuilder::asSuccess(ApiCodes::REGISTER_SUCCESS)
            ->build();
    }
}
