<?php

namespace Digia\Lumen\GraphQL;

/**
 * Class LockFile
 * @package Digia\Lumen\GraphQL
 */
class LockFile
{

    private const LOCK_FILE_NAME = 'graphql.schema.lock.json';

    /**
     * @return string
     */
    public static function getAbsolutePath(): string
    {
        return base_path() . '/' . self::LOCK_FILE_NAME;
    }

}
