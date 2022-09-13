<?php
declare(strict_types=1);

namespace TelegramBot\Traits;

/**
 * EnvironmentsTrait class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
trait EnvironmentsTrait
{

    /**
     * Admin chat id
     *
     * @var int
     */
    protected static int $adminId = -1;

    /**
     * Get env file path and return it
     *
     * @return string
     */
    public static function getEnvFilePath(): string
    {
        $defaultEnvPaths = [
            getcwd() . '/.env',
            getcwd() . '/../.env',
            $_SERVER['DOCUMENT_ROOT'] . '/.env',
        ];

        foreach ($defaultEnvPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return '';
    }

    /**
     * Set the admin chat id
     *
     * @return int
     */
    public static function getAdminId(): int
    {
        return static::$adminId;
    }

    /**
     * Set the admin chat id
     *
     * @param int $adminId
     */
    public static function setAdminId(int $adminId): void
    {
        static::$adminId = $adminId;
    }

    /**
     * Get token from env file.
     *
     * @param string $file
     * @return string|null
     */
    protected function getEnvToken(string $file): string|null
    {
        if (!file_exists($file)) return null;
        return $_ENV['TELEGRAM_BOT_TOKEN'] ?? null;
    }

}