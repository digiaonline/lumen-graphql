<?php

namespace Digia\Lumen\GraphQL\Tests\Http;

use Digia\Lumen\GraphQL\Execution\Processor;
use Digia\Lumen\GraphQL\GraphQLService;
use Digia\Lumen\GraphQL\Http\GraphQLController;
use Digia\Lumen\GraphQL\Models\GraphQLError;
use Digia\Lumen\GraphQL\Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class GraphQLControllerTest
 * @package ALehdet\ContentApi\Tests\Unit\GraphQL\Http
 */
class GraphQLControllerTest extends TestCase
{

    /**
     * Tests that the processor is used properly when handling requests
     */
    public function testHandle()
    {
        $service    = $this->getMockedService([]);
        $controller = new GraphQLController($service);

        $response = $controller->handle(new Request());

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals('[]', $response->getContent());
    }

    /**
     *
     */
    public function testHandleError()
    {
        $service = $this->getMockedService([
            'errors'     => ['foo' => 'bar'],
            'exceptions' => [
                new \Exception('foo'),
            ],
        ]);

        // Make a request and handle it
        $controller = new GraphQLController($service);

        $request = new Request();
        $request->merge([
            'query'     => 'Some query',
            'variables' => ['foo' => 'bar'],
        ]);

        $controller->handle($request);

        // Check that the error summary is properly set as an attribute
        $graphQLError = $request->attributes->get(GraphQLController::ATTRIBUTE_ERROR);
        $this->assertObjectHasAttribute('query', $graphQLError);
        $this->assertObjectHasAttribute('variables', $graphQLError);
        $this->assertObjectHasAttribute('exceptions', $graphQLError);

        $this->assertEquals(new GraphQLError(
            'Some query',
            ['foo' => 'bar'],
            [new \Exception('foo')]
        ), $graphQLError);
    }

    /**
     * Test render GraphiQL view
     */
    public function testRenderGraphiQL()
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject|GraphQLService $service */
        $service = $this->getMockBuilder(GraphQLService::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        // Make a request and handle it
        $controller = new GraphQLController($service);

        $this->assertInstanceOf(View::class, $controller->renderGraphiQL());
    }

    /**
     * @param array $responseData the response data that should be returned
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|GraphQLService $service
     */
    private function getMockedService(array $responseData)
    {
        // Mock the processor
        $processor = $this->getMockBuilder(Processor::class)
                          ->disableOriginalConstructor()
                          ->setMethods(['getResponseData', 'processPayload'])
                          ->getMock();

        $processor->expects($this->once())
                  ->method('processPayload')
                  ->willReturn($processor);

        $processor->expects($this->once())
                  ->method('getResponseData')
                  ->willReturn($responseData);

        /** @var \PHPUnit_Framework_MockObject_MockObject|GraphQLService $service */
        $service = $this->getMockBuilder(GraphQLService::class)
                        ->disableOriginalConstructor()
                        ->setMethods(['getProcessor'])
                        ->getMock();

        $service->expects($this->once())
                ->method('getProcessor')
                ->willReturn($processor);

        return $service;
    }

}
