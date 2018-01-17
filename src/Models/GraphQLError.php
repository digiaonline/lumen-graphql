<?php

namespace Digia\Lumen\GraphQL\Models;

class GraphQLError
{

    /**
     * @var string
     */
    protected $query;

    /**
     * @var array
     */
    protected $variables = [];

    /**
     * @var \Exception[]
     */
    protected $exceptions = [];

    /**
     * GraphQLError constructor.
     *
     * @param $query
     * @param $variables
     * @param $exceptions
     */
    public function __construct($query, $variables, $exceptions)
    {
        $this->query      = $query;
        $this->variables  = $variables;
        $this->exceptions = $exceptions;
    }

    /**
     * @return array
     */
    public function getExceptions(): array
    {
        return $this->exceptions;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }
}
