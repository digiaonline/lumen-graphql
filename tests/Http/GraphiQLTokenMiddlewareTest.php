<?php

namespace Digia\Lumen\GraphQL\Tests\Http;

use Digia\Lumen\GraphQL\Http\GraphiQLTokenMiddleware;
use Digia\Lumen\GraphQL\Tests\MiddlewareTestCase;
use Illuminate\Http\Request;

/**
 * Class GraphiQLTokenMiddlewareTest
 * @package ALehdet\ContentApi\Tests\Unit\GraphQL\Http\Middleware
 */
class GraphiQLTokenMiddlewareTest extends MiddlewareTestCase
{

    /**
     *
     */
    public function testHandle()
    {
        // Check that it passes when ENABLE_GRAPHIQL=true
        $this->assertMiddlewarePasses(new GraphiQLTokenMiddleware(true, null));

        // Check that it passes even if ENABLE_GRAPHIQL=false as long as a valid token is supplied
        $token   = 'foo';
        $request = new Request();
        $request->merge([
            'token' => $token,
        ]);

        $this->assertMiddlewarePasses(new GraphiQLTokenMiddleware(false, $token), $request);
    }

    /**
     * @expectedException \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function testHandleFailed()
    {
        $this->assertMiddlewareThrows(new GraphiQLTokenMiddleware(false, null));
    }

}
