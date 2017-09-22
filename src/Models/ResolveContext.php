<?php

namespace Digia\Lumen\GraphQL\Models;

use Youshido\GraphQL\Execution\ResolveInfo;

class ResolveContext
{

    /**
     * @var mixed
     */
    private $value;

    /**
     * @var array
     */
    private $arguments;

    /**
     * @var ?ResolveInfo
     */
    private $info;

    /**
     * ResolverContext constructor.
     *
     * @param mixed            $value
     * @param array            $arguments
     * @param null|ResolveInfo $info
     */
    public function __construct($value, array $arguments, ?ResolveInfo $info = null)
    {
        $this->value     = $value;
        $this->arguments = $arguments;
        $this->info      = $info;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param string $name
     * @return mixed|null
     */
    public function getArgument($name)
    {
        return $this->arguments[$name] ?: null;
    }

    /**
     * @return null|ResolveInfo
     */
    public function getInfo()
    {
        return $this->info;
    }
}