<?php

namespace Digia\Lumen\GraphQL\Helpers;

use Digia\JsonHelpers\JsonEncoder as BaseJsonEncoder;

/**
 * Class JsonEncoder
 * @package Digia\Lumen\GraphQL\Helpers
 */
class JsonEncoder extends BaseJsonEncoder
{

    /**
     * @var array unwanted JSON Unicode characters and their replacements
     */
    private static $unwantedJsonUnicodeCharacters = [
        "\\u2028" => '',
        "\\u2029" => '',
    ];

    /**
     * Encodes JSON with some additional filtering and sanitization. In contrast to just using json_encode(), this
     * method throws an exception if encoding fails.
     *
     * @param mixed $data the data to encode
     * @param int   $options
     * @param int   $depth
     *
     * @return string the encoded JSON
     *
     */
    public static function encode($data, int $options = 0, int $depth = 512): string
    {
        // Encode and convert encoding errors to exceptions
        $json = parent::encode($data);

        // Filter out unwanted Unicode characters from the encoded JSON
        return strtr($json, self::$unwantedJsonUnicodeCharacters);
    }

}
