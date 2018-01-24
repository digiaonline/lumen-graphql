<?php

namespace Digia\Lumen\GraphQL\Exceptions;

class EntityNotFoundException extends \Exception
{
    protected $message = 'Entity not found.';
}
