<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Models\Page;

class PaginationResolver
{

    /**
     * @param array $args
     *
     * @return int
     */
    public static function resolveFrom(array $args)
    {
        if (isset($args['after'])) {
            $index = (int)NodeIdResolver::idFromGlobalId($args['after']);

            // Logic: 19 (index) + 1 (next) = 20 (from)
            return $index + 1;
        }

        // Otherwise from is 0
        return 0;
    }

    /**
     * @param array $args
     *
     * @return int|null
     */
    public static function resolveSize(array $args)
    {
        return isset($args['first']) ? (int)$args['first'] : Page::DEFAULT_SIZE;
    }
}
