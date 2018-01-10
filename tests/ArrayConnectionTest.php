<?php

namespace Digia\Lumen\GraphQL\Tests;

use Digia\Lumen\GraphQL\ArrayConnection;

/**
 * Class ArrayConnectionTest
 * @package Digia\Lumen\GraphQL\Tests
 */
class ArrayConnectionTest extends TestCase
{

    /**
     * Tests that the array length is included in results
     */
    public function testArrayLength()
    {
        $data   = ['foo' => 1, 'bar' => 2];
        $result = ArrayConnection::connectionFromArraySlice($data, [], 0, count($data));

        $this->assertEquals(2, $result['total']);
    }

}
