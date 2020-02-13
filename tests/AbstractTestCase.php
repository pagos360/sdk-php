<?php

namespace Tests;

use Pagos360\RestClient;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @param array $input
     * @return RestClient|MockObject
     */
    public function mockRestClientGet(array $input)
    {
        /** @var MockObject|RestClient $mock */
        $mock = $this->createMock(RestClient::class);
        $mock->method('get')->willReturn($input);

        return $mock;
    }
}
