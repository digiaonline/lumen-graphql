<?php

namespace Digia\Lumen\GraphQL\Traits;

use Digia\Lumen\GraphQL\Contracts\TypeResolverInterface;

trait ResolvesTypeTrait
{

    /**
     * @param mixed $entity
     *
     * @return string
     */
    protected function resolveType($entity)
    {
        return $this->getTypeResolver()->resolveType($entity);
    }

    /**
     * @return TypeResolverInterface
     */
    protected function getTypeResolver()
    {
        return app(TypeResolverInterface::class);
    }
}
