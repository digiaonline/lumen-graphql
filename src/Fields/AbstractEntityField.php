<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Models\ResolveContext;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;

/**
 * Class AbstractEntityField
 * @package Digia\Lumen\GraphQL\Fields
 */
abstract class AbstractEntityField extends AbstractField
{

    /**
     * @param ResolveContext $context
     * @return mixed
     */
    abstract protected function resolveEntity(ResolveContext $context);

    /**
     * @inheritdoc
     */
    public function resolve($value, array $args, ResolveInfo $info)
    {
        $context = new ResolveContext($value, $args, $info);

        return $this->resolveEntity($context);
    }
}
