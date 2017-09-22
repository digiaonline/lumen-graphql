<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Models\ResolveContext;
use Digia\Lumen\GraphQL\Traits\ResolvesNodesTrait;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Type\InputObject\AbstractInputObjectType;
use Youshido\GraphQL\Type\NonNullType;

abstract class CreateEntityFieldAbstract extends AbstractField
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
    abstract protected function createEntity(ResolveContext $context);

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'Creates a new entity.';
    }

    /**
     * @inheritdoc
     */
    public function build(FieldConfig $config)
    {
        $config->addArgument($this->getEntityKey(), new NonNullType($this->getInputType()));
    }

    /**
     * @inheritdoc
     */
    public function resolve($value, array $args, ResolveInfo $info)
    {
        $context = new ResolveContext($value, $args, $info);

        return $this->createEntity($context);
    }

    /**
     * @inheritdoc
     */
    protected function getEntityKey()
    {
        return camel_case($this->getEntityTypeName());
    }

    /**
     * @param ResolveContext $context
     * @return array
     */
    protected function getEntityProperties(ResolveContext $context)
    {
        return $context->getArgument($this->getEntityKey());
    }
}
