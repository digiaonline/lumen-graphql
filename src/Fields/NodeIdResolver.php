<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Exceptions\MalformedNodeIdException;

class NodeIdResolver
{

    const INDEX_TYPE = 0;
    const INDEX_ID   = 1;

    /**
     * @param string $globalId
     * @return string
     */
    public static function typeFromGlobalId($globalId)
    {
        return self::fromGlobalId($globalId)[self::INDEX_TYPE];
    }

    /**
     * @param string $globalId
     * @return string
     */
    public static function idFromGlobalId($globalId)
    {
        return self::fromGlobalId($globalId)[self::INDEX_ID];
    }

    /**
     * @param string $typeName
     * @param string $id
     * @return string
     */
    public static function toGlobalId($typeName, $id)
    {
        return base64_encode(implode(':', [$typeName, $id]));
    }

    /**
     * @param string $globalId
     *
     * @return array
     * @throws MalformedNodeIdException
     */
    protected static function fromGlobalId($globalId)
    {
        $decodedGlobalId = base64_decode($globalId);

        if (strpos($decodedGlobalId, ':') === false) {
            throw new MalformedNodeIdException('Node ID is malformed.');
        }

        return explode(':', $decodedGlobalId);
    }
}
