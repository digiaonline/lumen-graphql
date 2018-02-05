<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Models\ResolveContext;
use Digia\Lumen\GraphQL\Traits\ResolvesNodesTrait;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\BooleanType;
use Youshido\GraphQL\Type\Scalar\IdType;

/**
 * Class AbstractDeleteEntityField
 * @package Digia\Lumen\GraphQL\Fields
 */
abstract class AbstractDeleteEntityField extends AbstractField
{

    use ResolvesNodesTrait;

    /**
     * @param ResolveContext $context
     * @return mixed
     */
    abstract protected function deleteEntity(ResolveContext $context);

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return new BooleanType();
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Deletes an existing entity.';
    }

    /**
     * @inheritdoc
     */
    public function build(FieldConfig $config)
    {
        $config->addArgument('id', new NonNullType(new IdType()));
    }

    /**
     * @inheritdoc
     */
    public function resolve($value, array $args, ResolveInfo $info)
    {
        $context = new ResolveContext($value, $args, $info);

        $this->deleteEntity($context);

        return true;
    }
}
