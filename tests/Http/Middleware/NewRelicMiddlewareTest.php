<?php

namespace ALehdet\ContentApi\Tests\Unit\GraphQL\Http;

use Digia\JsonHelpers\JsonEncoder;
use Digia\Lumen\GraphQL\Http\Middleware\NewRelicMiddleware;
use Digia\Lumen\GraphQL\Models\GraphQLError;
use Digia\Lumen\GraphQL\Tests\MiddlewareTestCase;
use Illuminate\Http\Request;
use Intouch\Newrelic\Newrelic;

/**
 * Class NewRelicMiddlewareTest
 * @package ALehdet\ContentApi\Tests\Unit\GraphQL\Http
 */
class NewRelicMiddlewareTest extends MiddlewareTestCase
{

    /**
     * Tests that the transaction name is correctly determined
     */
    public function testGetTransactionName()
    {
        // Create a request
        $request = new Request();
        $request->merge([
            'operationName' => 'foo',
        ]);

        /** @var NewRelicMiddleware $middleware */
        $middleware = $this->app->make(NewRelicMiddleware::class);
        $this->assertEquals('GraphQLController@foo', $middleware->getTransactionName($request));
    }

    /**
     * Tests that GraphQL errors are properly reported to New Relic
     */
    public function testHandle()
    {
        // Mock a NewRelic instance
        /** @var \PHPUnit_Framework_MockObject_MockObject|Newrelic $newRelic */
        $newRelic = $this->getMockBuilder(Newrelic::class)
                         ->setMethods(['noticeError'])
                         ->getMock();

        $graphQLError = new GraphQLError('Some query', ['foo' => 'bar'], [new \Exception()]);

        $newRelic->expects($this->once())
                 ->method('noticeError')
                 ->with(JsonEncoder::encode([
                     'query'     => $graphQLError->getQuery(),
                     'variables' => $graphQLError->getVariables(),
                     'message'   => '',
                 ]), $graphQLError->getExceptions()[0]);

        // Create a request with errors
        $request = new Request();
        $request->attributes->set(NewRelicMiddleware::ATTRIBUTE_ERROR, $graphQLError);

        $middleware = new NewRelicMiddleware($newRelic);
        $this->assertMiddlewarePasses($middleware, $request);

        // Check again with no errors - nothing should get reported
        $newRelic->expects($this->never())
                 ->method('noticeError');

        $this->assertMiddlewarePasses($middleware);
    }

}
