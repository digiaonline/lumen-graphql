<?php

use Digia\Lumen\GraphQL\Tests\TestCase;
use Digia\Lumen\GraphQL\Types\TypeResolver;
use Youshido\GraphQL\Config\Object\ObjectTypeConfig;
use Youshido\GraphQL\Type\Object\AbstractObjectType;

class TypeResolverTest extends TestCase
{

    public function setUp()
    {
        config([
            'graphql.types' => [
                'foo' => FooType::class,
            ],
        ]);
    }

    public function resolveTypeTest()
    {
        $className = TypeResolver::resolveType('foo');

        $this->assertEquals(FooType::class, $className);
    }
}

class FooType extends AbstractObjectType
{

    /**
     * @param ObjectTypeConfig $config
     */
    public function build($config)
    {
        // TODO: Implement build() method.
    }
}
