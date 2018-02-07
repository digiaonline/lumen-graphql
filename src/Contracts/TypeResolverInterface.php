<?php

namespace Digia\Lumen\GraphQL\Contracts;

use Youshido\GraphQL\Type\AbstractType;

interface TypeResolverInterface
{

    /**
     * @param array $entity
     * @return AbstractType
     */
    public static function resolveType(array $entity): AbstractType;
}
