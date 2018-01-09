<?php

namespace ALehdet\ContentApi\GraphQL;

use ALehdet\ContentApi\GraphQL\Types\MutationType;
use ALehdet\ContentApi\GraphQL\Types\QueryType;
use Youshido\GraphQL\Config\Schema\SchemaConfig;
use Youshido\GraphQL\Schema\AbstractSchema;

/**
 * Class Schema
 * @package ALehdet\ContentApi\GraphQL
 */
final class Schema extends AbstractSchema
{

    /**
     * @inheritdoc
     */
    public function build(SchemaConfig $config)
    {
        $config->setQuery(new QueryType());
        $config->setMutation(new MutationType());
    }
}
