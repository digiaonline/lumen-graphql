<?php

namespace Digia\Lumen\GraphQL\Tests\Models;

use Digia\Lumen\GraphQL\Models\ResolveContext;
use Digia\Lumen\GraphQL\Tests\TestCase;

/**
 * Class ResolveContextTest
 * @package Digia\Lumen\GraphQL\Tests\Models
 */
class ResolveContextTest extends TestCase
{

    public function testGetters()
    {
        $resolveContext = new ResolveContext('value', [
            'foo' => 'bar',
            'baz' => 'qux',
        ], null);

        $this->assertEquals('value', $resolveContext->getValue());
        $this->assertCount(2, $resolveContext->getArguments());
        $this->assertEquals('bar', $resolveContext->getArgument('foo'));
        $this->assertEquals('qux', $resolveContext->getArgument('baz'));
        $this->assertNull($resolveContext->getArgument('non-existing argument'));
    }
}
