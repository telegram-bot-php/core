<?php
declare(strict_types=1);

namespace TelegramBot;

use Exception;
use Symfony\Component\Dotenv\Dotenv;
use Throwable;

/**
 * CrashPad class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class CrashPad
{

    /**
     * Enable the crash handler
     *
     * @return void
     */
    public static function enableCrashHandler(): void
    {
        $handler = function (Throwable $throwable) {
            if (Telegram::getAdminId() !== -1) {
                $input = getenv('TG_CURRENT_UPDATE') ?? Telegram::getInput();
                CrashPad::sendCrash(Telegram::getAdminId(), $throwable, $input);
            }

            if (!defined('DEBUG_MODE')) {
                throw new \RuntimeException(
                    'Something went wrong, Unfortunately, we can not handle this error.', 0, $throwable
                );
            }

            CrashPad::print($throwable);
        };

        set_exception_handler($handler);
    }

    /**
     * Debug mode. Catch the crash reports.
     *
     * @param int $admin_id (optional) The admin chat id.
     * @return void
     */
    public static function setDebugMode(int $admin_id = -1): void
    {
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        defined('DEBUG_MODE') or define('DEBUG_MODE', true);
        if ($admin_id !== -1) {
            Telegram::setAdminId($admin_id);
        }

        self::enableCrashHandler();
    }

    /**
     * Send crash message and log
     *
     * @param int $chat_id The chat id of the group to send the message to.
     * @param Exception|Throwable $exception The exception to report.
     * @param string|null $update (Optional) The update that caused the exception.
     *
     * @retrun bool
     */
    public static function sendCrash(int $chat_id, Exception|Throwable $exception, string|null $update = null): bool
    {
        if ($chat_id === -1) {
            throw new \RuntimeException(sprintf(
                'The given `chat_id` is not valid. given: %s',
                $chat_id
            ));
        }

        if (!Telegram::validateToken($_ENV['TELEGRAM_BOT_TOKEN'] ?? '')) {
            (new Dotenv())->load(Telegram::getEnvFilePath());
            Telegram::setToken($_ENV['TELEGRAM_BOT_TOKEN']);
        }

        if (($token = self::loadToken()) === null) {
            throw new \RuntimeException(
                'The token is not set. Please set the token using `Telegram::setToken()` method.'
            );
        }

        $text = Request::sendMessage([
            'bot_token' => $token,
            'chat_id' => $chat_id,
            'parse_mode' => 'HTML',
            'text' => sprintf(
                "<b>Message</b>: %s\n\n<b>File</b>: %s(%d)\n\n<b>Trace</b>: \n%s",
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
                $exception->getTraceAsString()
            ),
        ]);

        $document = Request::sendDocument([
            'bot_token' => $token,
            'chat_id' => $chat_id,
            'document' => self::createCrashFile(sprintf(
                "Message: %s\n\nFile: %s(%d)\n\nTrace: \n%s\n\nUpdate: \n%s",
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
                $exception->getTraceAsString(),
                $update ?? 'Did not receive update.'
            )),
        ]);

        return $text->isOk() && $document->isOk();
    }

    /**
     * Create a log file for the error.
     *
     * @param string $content The content of the log file.
     * @retrun string The path of the log file.
     */
    private static function createCrashFile(string $content): string
    {
        $base_path = $_SERVER['DOCUMENT_ROOT'] . '.telegram-bot/';
        if (!file_exists($base_path)) {
            mkdir($base_path, 0777, true);
        }

        file_put_contents(($file = $base_path . uniqid('error_') . '.log'), $content);
        return $file;
    }

    /**
     * Report the error to the developers from the Telegram Bot API.
     *
     * @param Exception|Throwable $exception The exception to report.
     * @retrun void
     */
    public static function print(Exception|Throwable $exception): void
    {
        TelegramLog::error(($message = sprintf(
            "%s(%d): %s\n%s",
            $exception->getFile(),
            $exception->getLine(),
            $exception->getMessage(),
            $exception->getTraceAsString()
        )));
        echo '<b>TelegramError:</b> ' . $message;
    }

    /**
     * Clear the crash logs.
     *
     * @return void
     */
    public static function clearCrashLogs(): void
    {
        $base_path = $_SERVER['DOCUMENT_ROOT'] . '.telegram-bot/';
        if (!file_exists($base_path)) {
            return;
        }

        $files = glob($base_path . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    /**
     * Check is there any loaded token or any token in the environment file.
     *
     * @return string|null
     */
    private static function loadToken(): string|null
    {
        if (($token = Telegram::getApiToken()) !== false) {
            return $token;
        }

        if (file_exists(Telegram::getEnvFilePath())) {
            (new Dotenv())->load(Telegram::getEnvFilePath());
            return $_ENV['TELEGRAM_BOT_TOKEN'] ?? null;
        }

        return null;
    }

}