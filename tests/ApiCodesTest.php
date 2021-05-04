<?php

namespace Tests;

use MarcinOrlowski\ResponseBuilder\Tests\Traits\ApiCodesTests;

class ApiCodesTest extends TestCase
{
    use ApiCodesTests;

    public function getApiCodesClassName(): string
    {
        return TestableApiCodes::class;
    }
}
