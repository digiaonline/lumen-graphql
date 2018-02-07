<?php

namespace Digia\Lumen\GraphQL\Types;

use Youshido\GraphQL\Type\Object\AbstractObjectType as BaseAbstractObjectType;

/**
 * Class AbstractObjectType
 * @package Digia\Lumen\GraphQL\Types
 */
class AbstractObjectType extends BaseAbstractObjectType
{

    /**
     * @inheritdoc
     */
    public function build($config)
    {
        // Apply defined interfaces
        foreach ($this->getInterfaces() as $interface) {
            $config->applyInterface($interface);
        }
    }
}
