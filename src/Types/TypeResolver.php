<?php

namespace Digia\Lumen\GraphQL\Types;

use Digia\Lumen\GraphQL\Contracts\TypeResolverInterface;
use Digia\Lumen\GraphQL\Exceptions\UnsupportedTypeException;
use Youshido\GraphQL\Type\AbstractType;

/**
 * Class TypeResolver
 * @package Digia\Lumen\GraphQL\Types
 */
class TypeResolver implements TypeResolverInterface
{
    /**
     * @param array $object
     *
     * @return AbstractType
     *
     * @throws UnsupportedTypeException
     */
    public static function resolveType(array $object): AbstractType
    {
        if (!array_key_exists($object['type'], config('graphql.types'))) {
            throw new UnsupportedTypeException(sprintf('Unsupported entity type `%s`.', $object['type']));
        }

        $className = config('graphql.types')[$object['type']];

        return new $className();
    }
}
