<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Models\ResolveContext;
use Digia\Lumen\GraphQL\Traits\ResolvesNodesTrait;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\InputObject\AbstractInputObjectType;
use Youshido\GraphQL\Type\NonNullType;
use Youshido\GraphQL\Type\Scalar\IdType;

/**
 * Class AbstractUpdateEntityField
 * @package Digia\Lumen\GraphQL\Fields
 */
abstract class AbstractUpdateEntityField extends AbstractField
{

    use ResolvesNodesTrait;

    /**
     * @return string
     */
    abstract protected function getEntityTypeName();

    /**
     * @return AbstractInputObjectType
     */
    abstract protected function getInputType();

    /**
     * @param ResolveContext $context
     * @return mixed
     */
    abstract protected function updateEntity(ResolveContext $context);

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Updates an existing entity.';
    }

    /**
     * @inheritdoc
     */
    public function build(FieldConfig $config)
    {
        $config->addArgument('id', new NonNullType(new IdType()));
        $config->addArgument($this->getEntityKey(), new NonNullType($this->getInputType()));
    }

    /**
     * @inheritdoc
     * @suppress PhanTypeMismatchArgument
     */
    public function resolve($value, array $args, ResolveInfo $info)
    {
        $context = new ResolveContext($value, $args, $info);

        return $this->updateEntity($context);
    }

    /**
     * @inheritdoc
     */
    protected function getEntityKey()
    {
        return camel_case($this->getEntityTypeName());
    }
}
