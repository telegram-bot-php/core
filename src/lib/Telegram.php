<?php

namespace TelegramBot;

use TelegramBot\Entities\Response;
use TelegramBot\Entities\Update;
use TelegramBot\Exception\TelegramException;
use TelegramBot\Util\DotEnv;
use TelegramBot\Util\Utils;

/**
 * Telegram
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class Telegram
{

    /**
     * @var string
     */
    private string $api_key;

    /**
     * @var string
     */
    public static string $VERSION = 'v1.0.0';

    /**
     * Telegram constructor.
     *
     * @param string $api_key
     */
    public function __construct(string $api_key = '')
    {
        if ($api_key === '') {
            $defaultEnvPaths = [
                $_SERVER['DOCUMENT_ROOT'] . '/.env',
                getcwd() . '/.env'
            ];

            foreach ($defaultEnvPaths as $path) {
                if (file_exists($path)) {
                    $api_key = DotEnv::load($path)::get('TELEGRAM_API_KEY');
                    break;
                }
            }
        }

        if (empty($api_key) || !is_string($api_key)) {
            throw new TelegramException('API Key is required');
        }

        DotEnv::put('TG_CURRENT_KEY', ($this->api_key = $api_key));
        DotEnv::put('TELEGRAM_API_KEY', ($this->api_key = $api_key));
    }

    /**
     * Get API key from temporary ENV variable
     *
     * @return string
     */
    public static function getApiKey(): string
    {
        return DotEnv::get('TG_CURRENT_KEY');
    }

    /**
     * Get bot info from given API key
     *
     * @return Response
     * @throws TelegramException
     */
    public function getInfo(): Response
    {
        $result = Request::getMe();

        if (!$result->isOk()) {
            throw new TelegramException($result->getErrorCode() . ': ' . $result->getDescription());
        }

        return $result;
    }

    /**
     * Set Webhook for bot
     *
     * @param string $url
     * @param array $data Optional parameters.
     * @return Response
     * @throws TelegramException
     */
    public function setWebhook(string $url, array $data = []): Response
    {
        if ($url === '') {
            throw new TelegramException('Hook url is empty!');
        }

        if (!str_starts_with($url, 'https://')) {
            throw new TelegramException('Hook url must start with https://');
        }

        $data = array_intersect_key($data, array_flip([
            'certificate',
            'ip_address',
            'max_connections',
            'allowed_updates',
            'drop_pending_updates',
        ]));
        $data['url'] = $url;

        $result = Request::setWebhook($data);

        if (!$result->isOk()) {
            throw new TelegramException(
                'Webhook was not set! Error: ' . $result->getErrorCode() . ' ' . $result->getDescription()
            );
        }

        return $result;
    }

    /**
     * Delete any assigned webhook
     *
     * @param array $data
     * @return Response
     * @throws TelegramException
     */
    public function deleteWebhook(array $data = []): Response
    {
        $result = Request::deleteWebhook($data);

        if (!$result->isOk()) {
            throw new TelegramException(
                'Webhook was not deleted! Error: ' . $result->getErrorCode() . ' ' . $result->getDescription()
            );
        }

        return $result;
    }

    /**
     * Get input from stdin and return it
     *
     * @return string
     */
    public static function getInput(): string
    {
        if (DotEnv::get('TG_CUSTOM_INPUT') !== null) {
            return DotEnv::get('TG_CUSTOM_INPUT');
        }
        return file_get_contents('php://input');
    }

    /**
     * This method will convert a string to an update object
     *
     * @param string $input The input string
     * @return Update|false
     */
    public static function processUpdate(string $input): Update|false
    {
        if ($input === '' || Utils::isJson($input) === false) {
            throw new TelegramException('Input is empty!');
        }

        $update = new Update(json_decode($input, true));

        if (!$update->isOk()) return false;

        return $update;
    }

    /**
     * Get the update from input
     *
     * @return Update|false
     */
    public static function getUpdate(): Update|false
    {
        $input = self::getInput();
        if ($input === '' || Utils::isJson($input) === false) return false;
        return (new Telegram())->processUpdate($input);
    }

    /**
     * Validate the token
     *
     * @param string $token (e.g. 123456789:ABC-DEF1234ghIkl-zyx57W2v1u123ew11) {digit}:{alphanumeric[34]}
     * @return bool
     */
    public static function validateToken(string $token): bool
    {
        preg_match_all('/([0-9]+:[a-zA-Z0-9-_]+)/', $token, $matches);
        return count($matches[0]) == 1;
    }

    /**
     * Pass the update to the given webhook handler
     *
     * @param WebhookHandler $webhook_handler The webhook handler
     * @param ?Update $update By default, it will get the update from input
     * @return void
     */
    public function fetchWith(WebhookHandler $webhook_handler, ?Update $update = null): void
    {
        if (is_subclass_of($webhook_handler, WebhookHandler::class)) {
            if ($update === null) $update = self::getUpdate();
            $webhook_handler->resolve($update);
        }
    }

    /**
     * Get token from env file.
     *
     * @param string $file
     * @return ?string
     */
    protected function getTokenFromEnvFile(string $file): ?string
    {
        if (!file_exists($file)) return null;
        return DotEnv::load($file)::get('TELEGRAM_API_KEY');
    }

    /**
     * Just another echo
     *
     * @param string $text
     * @return void
     */
    public static function echo(string $text): void
    {
        echo $text;
    }

}