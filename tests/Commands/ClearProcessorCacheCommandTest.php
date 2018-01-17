<?php

namespace Digia\Lumen\GraphQL\Tests\Commands;

use Digia\Lumen\GraphQL\Commands\ClearProcessorCacheCommand;
use Digia\Lumen\GraphQL\GraphQLService;
use Digia\Lumen\GraphQL\Tests\TestCase;

/**
 * Class ClearProcessorCacheCommandTest
 * @package Digia\Lumen\GraphQL\Tests\Commands
 */
class ClearProcessorCacheCommandTest extends TestCase
{
    /**
     * Tests that the command correctly calls the service
     */
    public function testHandle()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|GraphQLService $service */
        $service = $this->getMockBuilder(GraphQLService::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['forgetProcessor'])
                        ->getMock();

        $service->expects($this->once())
                ->method('forgetProcessor');

        $command = new ClearProcessorCacheCommand($service);
        $command->handle();
    }
}
