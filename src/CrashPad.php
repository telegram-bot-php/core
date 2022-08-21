<?php
declare(strict_types=1);

namespace TelegramBot;

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
     * Admin chat id
     *
     * @var int
     */
    private static int $adminChatId = -1;

    /**
     * Report the error to the developers from the Telegram Bot API.
     *
     * @param int $chat_id The chat id of the group to send the message to.
     * @param \Exception $exception The exception to report.
     * @param string|null $update (Optional) The update that caused the exception.
     * @retrun bool
     */
    public static function report(int $chat_id, \Exception $exception, string|null $update = null): bool
    {
        if ($chat_id === -1) {
            throw new \RuntimeException(sprintf(
                'The given `chat_id` is not valid. given: %s',
                $chat_id
            ));
        }

        TelegramLog::error(($message = sprintf(
            "%s(%d): %s\n%s",
            $exception->getFile(),
            $exception->getLine(),
            $exception->getMessage(),
            $exception->getTraceAsString()
        )));

        echo '<b>TelegramError:</b> ' . $message;

        $text = Request::sendMessage([
            'chat_id' => $chat_id,
            'text' => $message,
        ]);

        if ($update !== null) {
            $document = Request::sendDocument([
                'chat_id' => $chat_id,
                'document' => self::createCrashFile(
                    $message . "\n\n" . $update
                ),
            ]);
            return $text->isOk() && $document->isOk();
        }

        return $text->isOk();
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
     * Clear crash files.
     *
     * @return void
     */
    public static function clearCrashFiles(): void
    {
        $files = glob(getcwd() . '.telegram-bot/*.log');
        foreach ($files as $file) {
            unlink($file);
        }
    }

    /**
     * @return int
     */
    public static function getAdminChatId(): int
    {
        return static::$adminChatId;
    }

    /**
     * @param int $adminChatId
     */
    public static function setAdminChatId(int $adminChatId): void
    {
        static::$adminChatId = $adminChatId;
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
            CrashPad::setAdminChatId($admin_id);
        }

        set_exception_handler(function ($exception) {
            if (!defined('DEBUG_MODE') && !DEBUG_MODE) {
                throw $exception;
            } else {
                if (CrashPad::getAdminChatId() !== -1) {
                    $input = getenv('TG_CURRENT_UPDATE') ?? Telegram::getInput();
                    $update = Telegram::processUpdate($input, Telegram::getApiToken());
                    CrashPad::report(CrashPad::getAdminChatId(), $exception, json_encode($update));
                }
            }
        });
    }

}