<?php

namespace TelegramBot\Util;

/**
 * DotEnv
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
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
     * @param ?string $path
     * @return DotEnv
     */
    public static function load(string $path = null): self
    {
        if (empty($path)) $data = self::read(getcwd() . '/.env');
        else $data = self::read($path);
        foreach ($data as $item) {
            [$key, $value] = $item;
            if (count($item) == 2) {
                putenv(trim($key) . '=' . trim($value));
            }
        }

        return new self();
    }

    /**
     * Read environment variable
     *
     * @param string $key The Key of the environment variable
     * @param string $default The default value if the key is not found
     * @return string
     */
    public static function get(string $key, string $default = ''): string
    {
        return getenv($key) ?: $default;
    }

    /**
     * Put environment variable
     *
     * @param string $key The Key of the environment variable
     * @param string $value The Value of the environment variable
     * @param bool $save (default: false)
     *
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
     * @return bool
     */
    public static function saveTo(string $path, array $input): bool
    {
        $content = '';
        $data = array_merge(self::read($path), $input);
        foreach ($data as $item) {
            if (count($item) == 2) {
                $content .= $item[0] . '=' . $item[1] . "\n";
            }
        }
        return file_put_contents($path, $content) !== false;
    }

    /**
     * Find the .env file location
     *
     * @return string
     */
    public static function find(): string
    {
        while (true) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/.env')) {
                return $_SERVER['DOCUMENT_ROOT'] . '/.env';
            }
            if ($_SERVER['DOCUMENT_ROOT'] == '/') {
                return '';
            }
            $_SERVER['DOCUMENT_ROOT'] = dirname($_SERVER['DOCUMENT_ROOT']);
        }
    }

}