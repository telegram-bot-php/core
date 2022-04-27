<?php

namespace TelegramBot\Util;

/**
 * Class Utils
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class Utils
{

    /**
     * Validate the given string is JSON or not
     *
     * @param ?string $string
     * @return bool
     */
    public static function isJson(?string $string): bool
    {
        if (!is_string($string)) return false;
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Debug mode
     *
     * @return void
     */
    public static function setDebugMode(): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    }


}