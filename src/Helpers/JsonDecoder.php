<?php

namespace Digia\Lumen\GraphQL\Helpers;

use Digia\JsonHelpers\JsonDecoder as BaseJsonDecoder;

/**
 * Class JsonDecoder
 * @package ALehdet\ContentApi\App\Helpers
 */
class JsonDecoder extends BaseJsonDecoder
{

    /**
     * @param string $data
     *
     * @param bool   $assoc
     * @param int    $depth
     * @param int    $options
     *
     * @return array
     */
    public static function decode(string $data, bool $assoc = false, int $depth = 512, int $options = 0): array
    {
        // Force associative arrays
        return parent::decode($data, true, $depth, $options);
    }
}
