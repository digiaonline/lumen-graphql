<?php

namespace Digia\Lumen\GraphQL\Types;

use Digia\Lumen\GraphQL\Traits\ResolvesTypeTrait;
use Youshido\GraphQL\Type\InterfaceType\AbstractInterfaceType;
use Youshido\GraphQL\Type\NonNullType;

class TimestampsInterfaceType extends AbstractInterfaceType
{

    use ResolvesTypeTrait;

    /**
     * @inheritdoc
     */
    public function build($config)
    {
        $config->addFields([
            'createdAt' => new NonNullType(new UTCTimeType()),
            'updatedAt' => new NonNullType(new UTCTimeType()),
        ]);
    }
}