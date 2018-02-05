<?php

namespace Digia\Lumen\GraphQL\Fields;

use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;

abstract class AbstractNodeField extends AbstractEntityField
{

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Returns a node with the given ID.';
    }

    /**
     * @inheritdoc
     */
    public function build(FieldConfig $config)
    {
        $config->addArgument('id', new NonNullType(new IdType()));
    }
}
