<?php

namespace Digia\Lumen\GraphQL\Fields;

use Digia\Lumen\GraphQL\Traits\ResolvesTypeTrait;
use Youshido\GraphQL\Relay\Field\GlobalIdField;
use Youshido\GraphQL\Type\InterfaceType\AbstractInterfaceType;

class NodeInterfaceType extends AbstractInterfaceType
{

    use ResolvesTypeTrait;

    /**
     * @var string
     */
    private $typeName;

    /**
     * NodeInterface constructor.
     *
     * @param string $typeName
     */
    public function __construct($typeName)
    {
        parent::__construct();

        $this->typeName = $typeName;
    }

    /**
     * @inheritdoc
     */
    public function build($config)
    {
        $config->addField(new GlobalIdField($this->typeName));
    }
}
