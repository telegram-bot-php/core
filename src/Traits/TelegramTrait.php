<?php
declare(strict_types=1);

namespace TelegramBot\Traits;

/**
 * TelegramTrait class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
trait TelegramTrait
{

    /**
     * Admin chat id
     *
     * @var int
     */
    private static int $adminId = -1;

    /**
     * Get env file path and return it
     *
     * @return string
     */
    private function getEnvFilePath(): string
    {
        $defaultEnvPaths = [
            $_SERVER['DOCUMENT_ROOT'] . '/.env',
            getcwd() . '/../.env',
            getcwd() . '/.env',
        ];

        foreach ($defaultEnvPaths as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return '';
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

}