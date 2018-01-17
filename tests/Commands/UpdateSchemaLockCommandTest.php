<?php

namespace Digia\Lumen\GraphQL\Tests\Commands;

use Digia\Lumen\GraphQL\GraphQLService;
use Digia\Lumen\GraphQL\Tests\TestCase;
use Digia\Lumen\GraphQL\Commands\UpdateSchemaLockCommand;

/**
 * Class UpdateSchemaLockCommand
 * @package Digia\Lumen\GraphQL\Tests\Commands
 */
class UpdateSchemaLockCommandTest extends TestCase
{
    /**
     * Tests that the command correctly calls the service
     */
    public function testHandle()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|GraphQLService $service */
        $service = $this->getMockBuilder(GraphQLService::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['getStoredQueryResponse'])
                        ->getMock();

        $service->expects($this->once())
                ->method('getStoredQueryResponse')
                ->with('graphql/Introspection.graphql');

        $command = new UpdateSchemaLockCommand($service);
        $command->handle();
    }
}
