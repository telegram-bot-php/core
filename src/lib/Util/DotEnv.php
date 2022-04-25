<?php

namespace TelegramBot\Util;

/**
 * DotEnv
 *
 * @link    https://github.com/shahradelahi/telegram-bot
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/telegram-bot/blob/master/LICENSE (MIT License)
 */
class DotEnv
{

    /**
     * Read file and fetch environment variable
     *
     * @param string $path
     * @return array
     */
    public static function read(string $path): array
    {
        if (!file_exists($path)) {
            return [];
        }
        $data = file_get_contents($path);
        return array_map(function ($item) {
            return explode('=', $item);
        }, explode("\n", $data));
    }

    /**
     * Load environment variables from .env file in root directory
     *
     * @return DotEnv
     */
    public static function load(): self
    {
        self::loadFrom($_SERVER['DOCUMENT_ROOT'] . '/.env');

        return new self();
    }

    /**
     * Loads environment variables from .env file
     *
     * @param string $path
     * @return DotEnv
     */
    public static function loadFrom(string $path): self
    {
        $data = self::read($path);
        foreach ($data as $item) {
            if (count($item) == 2) {
                putenv($item[0] . '=' . $item[1]);
            }
        }

        return new self();
    }

    /**
     * Read environment variable
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public static function get(string $key, string $default = ''): string
    {
        return getenv($key) ?: $default;
    }

    /**
     * Put environment variable
     *
     * @param string $key
     * @param string $value
     * @param bool $save (default: false)
     * @return void
     */
    public static function put(string $key, string $value, bool $save = false): void
    {
        putenv($key . '=' . $value);
        if ($save) self::saveTo($_SERVER['DOCUMENT_ROOT'] . '/.env', [$key => $value]);
    }

    /**
     * Save environment variables to given file
     *
     * @param string $path The absolute path to the file
     * @param array $input The environment variables to save
     * @return void
     */
    public static function saveTo(string $path, array $input): void
    {
        $data = array_merge(self::read($path), $input);
        $content = '';
        foreach ($data as $item) {
            if (count($item) == 2) {
                $content .= $item[0] . '=' . $item[1] . "\n";
            }
        }
        file_put_contents($path, $content);
    }

}