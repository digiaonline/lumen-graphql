<?php

namespace Digia\Lumen\GraphQL\Contracts;

use Youshido\GraphQL\Type\AbstractType;

interface TypeResolverInterface
{

    /**
     * @param mixed $entity
     * @return AbstractType
     */
    public function resolveType($entity);
}