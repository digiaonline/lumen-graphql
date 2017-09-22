<?php

namespace Digia\Lumen\GraphQL\Traits;

use Digia\Lumen\GraphQL\Fields\NodeIdResolver;

trait ResolvesNodesTrait
{

    /**
     * @param string $globalId
     *
     * @return string
     */
    protected static function nodeTypeFromGlobalId($globalId)
    {
        return NodeIdResolver::typeFromGlobalId($globalId);
    }

    /**
     * @param string $globalId
     *
     * @return string
     */
    protected function nodeIdFromGlobalId($globalId)
    {
        return NodeIdResolver::idFromGlobalId($globalId);
    }

    /**
     * @param string $typeName
     * @param string $id
     *
     * @return string
     */
    protected function createNodeGlobalId($typeName, $id)
    {
        return NodeIdResolver::toGlobalId($typeName, $id);
    }
}