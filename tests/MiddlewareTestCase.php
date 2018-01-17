<?php

namespace Digia\Lumen\GraphQL\Tests;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class MiddlewareTestCase
 * @package Digia\Lumen\GraphQL\Tests
 */
abstract class MiddlewareTestCase extends TestCase
{

    /**
     * @param mixed        $middleware
     * @param Request|null $request
     */
    public function assertMiddlewarePasses($middleware, ?Request $request = null): void
    {
        if ($request === null) {
            $request = new Request();
        }

        $this->assertInstanceOf(Response::class, $middleware->handle($request, function () {
            return new Response();
        }));
    }

    /**
     * @param mixed        $middleware
     * @param Request|null $request
     */
    public function assertMiddlewareThrows($middleware, ?Request $request = null): void
    {
        if ($request === null) {
            $request = new Request();
        }

        $middleware->handle($request, function () {
            return new Response();
        });

        $this->fail('Expected middleware to throw an exception, nothing was thrown');
    }

}
