<?php

namespace Digia\Lumen\GraphQL\Tests\Fields;

use Digia\Lumen\GraphQL\Fields\NodeIdResolver;
use Digia\Lumen\GraphQL\Tests\TestCase;

class NodeIdResolverTest extends TestCase
{

    /**
     *
     */
    public function testIdFromGlobalId()
    {
        $globalId = base64_encode('Test:1');

        $id = NodeIdResolver::idFromGlobalId($globalId);

        $this->assertEquals('1', $id);
    }

    /**
     * @expectedException \Digia\Lumen\GraphQL\Exceptions\MalformedNodeIdException
     * @expectedExceptionMessage Node ID "Test1" is malformed.
     */
    public function testIdFromGlobalIdWithMalformedId()
    {
        NodeIdResolver::idFromGlobalId('Test1');
    }

    /**
     *
     */
    public function testTypeFromGlobalId()
    {
        $globalId = base64_encode('Test:1');

        $id = NodeIdResolver::typeFromGlobalId($globalId);

        $this->assertEquals('Test', $id);
    }

    /**
     *
     */
    public function testToGlobalId()
    {
        $globalId = NodeIdResolver::toGlobalId('Test', '1');

        $expected = base64_encode(implode(':', ['Test', '1']));

        $this->assertEquals($expected, $globalId);
    }
}
