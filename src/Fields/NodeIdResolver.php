<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Exceptions\MalformedNodeIdException;

class NodeIdResolver
{

    private const INDEX_TYPE = 0;
    private const INDEX_ID   = 1;

    /**
     * @param string $globalId
     *
     * @return string
     * @throws MalformedNodeIdException
     */
    public static function typeFromGlobalId($globalId): string
    {
        return self::fromGlobalId($globalId)[self::INDEX_TYPE];
    }

    /**
     * @param string $globalId
     *
     * @return string
     * @throws MalformedNodeIdException
     */
    public static function idFromGlobalId($globalId): string
    {
        return self::fromGlobalId($globalId)[self::INDEX_ID];
    }

    /**
     * @param string $typeName
     * @param string $id
     *
     * @return string
     */
    public static function toGlobalId($typeName, $id): string
    {
        return base64_encode(implode(':', [$typeName, $id]));
    }

    /**
     * @param string $globalId
     *
     * @return array
     * @throws MalformedNodeIdException
     */
    protected static function fromGlobalId($globalId): array
    {
        $decodedGlobalId = base64_decode($globalId);

        if (strpos($decodedGlobalId, ':') === false) {
            throw new MalformedNodeIdException(sprintf('Node ID "%s" is malformed.', $globalId));
        }

        return explode(':', $decodedGlobalId);
    }
}
