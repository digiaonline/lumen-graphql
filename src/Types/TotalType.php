<?php

namespace Digia\Lumen\GraphQL\Types;

use Youshido\GraphQL\Exception\ConfigurationException;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\AbstractScalarType;
use Youshido\GraphQL\Type\Scalar\IntType;

/**
 * Class TotalType
 * @package Digia\Lumen\GraphQL\Types
 */
class TotalType extends AbstractScalarType
{

    /**
     * @inheritdoc
     */
    public function getDescription(): string
    {
        return 'The total number of results for a connection.';
    }

    /**
     * @inheritdoc
     *
     * @throws ConfigurationException
     */
    public function getType()
    {
        return new NonNullType(new IntType());
    }
}
