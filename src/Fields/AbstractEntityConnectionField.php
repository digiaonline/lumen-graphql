<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Models\Page;
use Digia\Lumen\GraphQL\Models\ResolveContext;
use Youshido\GraphQL\Config\Field\FieldConfig;
use Youshido\GraphQL\Execution\ResolveInfo;
use Youshido\GraphQL\Field\AbstractField;
use Youshido\GraphQL\Relay\Connection\ArrayConnection;
use Youshido\GraphQL\Relay\Connection\Connection;
use Youshido\GraphQL\Type\AbstractType;

/**
 * Class AbstractEntityConnectionField
 * @package Digia\Lumen\GraphQL\Fields
 */
abstract class AbstractEntityConnectionField extends AbstractField
{

    /**
     * @return AbstractType
     */
    abstract protected function getEntityType();

    /**
     * @param ResolveContext $context
     *
     * @return Page
     */
    abstract protected function createPage(ResolveContext $context);

    /**
     * @inheritdoc
     */
    public function getType()
    {
        return Connection::connectionDefinition($this->getEntityType());
    }

    /**
     * @inheritdoc
     */
    public function build(FieldConfig $config)
    {
        $config->addArguments(Connection::connectionArgs());
    }

    /**
     * @inheritdoc
     */
    public function resolve($value, array $args, ResolveInfo $info)
    {
        $context = new ResolveContext($value, $args, $info);

        $page = $this->createPage($context);

        return ArrayConnection::connectionFromArraySlice(
            $page->getData(),
            $context->getArguments(),
            $page->getFrom(),
            $page->getTotal()
        );
    }
}
