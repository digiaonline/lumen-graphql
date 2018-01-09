<?php

namespace Digia\Lumen\GraphQL;

use Youshido\GraphQL\Relay\Connection\ArrayConnection as BaseArrayConnection;

class ArrayConnection extends BaseArrayConnection
{

    /** @noinspection MoreThanThreeArgumentsInspection */

    /**
     * @param array $data
     * @param array $args
     * @param int   $sliceStart
     * @param int   $arrayLength
     *
     * @return array
     */
    public static function connectionFromArraySlice(array $data, array $args, $sliceStart, $arrayLength)
    {
        return array_merge(parent::connectionFromArraySlice($data, $args, $sliceStart, $arrayLength), [
            'total' => $arrayLength,
        ]);
    }
}
