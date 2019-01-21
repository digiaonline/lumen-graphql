<?php

namespace Digia\Lumen\GraphQL\Tests\Fields;

use Digia\Lumen\GraphQL\Fields\PaginationResolver;
use Digia\Lumen\GraphQL\Models\Page;
use Digia\Lumen\GraphQL\Tests\TestCase;

class PaginationResolverTest extends TestCase
{

    public function testFirstAndAfter()
    {
        $args = [
            'first' => 10,
            'after' => 'YXJyYXljb25uZWN0aW9uOjE5', // arrayconnection:19
        ];

        $this->assertEquals(20, PaginationResolver::resolveFrom($args));
        $this->assertEquals($args['first'], PaginationResolver::resolveSize($args));

        $args = [];

        $this->assertEquals(Page::DEFAULT_SIZE, PaginationResolver::resolveSize($args));
    }
}
