<?php

namespace Digia\Lumen\GraphQL\Types;

use Youshido\GraphQL\Type\Scalar\StringType;

class UTCTimeType extends StringType
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'UTCTime';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'A time expressed in UTC.';
    }
}