<?php

namespace TelegramBot\Util;

/**
 * Class Common
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class Common
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
        defined('DEBUG_MODE') or define('DEBUG_MODE', true);
    }

    /**
     * Arrest with exception
     *
     * @param callable $callback Callback function
     * @param mixed ...$args The arguments to pass to the callback
     * @return mixed
     */
    public static function arrest(callable $callback, ...$args): mixed
    {
        try {
            return $callback($args);
        } catch (\Throwable|\TypeError|\Exception $e) {
            echo '<b>Error:</b> ' . $e->getMessage() . PHP_EOL;
            throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }

}