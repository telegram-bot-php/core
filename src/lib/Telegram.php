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
 * @link    https://github.com/shahradelahi/telegram-bot
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/telegram-bot/blob/master/LICENSE (MIT License)
 */
class Telegram
{

    /**
     * @var string
     */
    public static string $VERSION = 'v1.0.0';

    /**
     * @var string
     */
    private string $api_key;

    /**
     * @var string
     */
    private string $custom_input;

    /**
     * @var string
     */
    private string $bot_username;

    /**
     * Telegram constructor.
     *
     * @param string $api_key
     * @param string $bot_username
     */
    public function __construct(string $api_key = '', string $bot_username = '')
    {
        if ($api_key === '') {
            $api_key = DotEnv::load()::get('TELEGRAM_API_KEY');
            $bot_username = DotEnv::load()::get('TELEGRAM_BOT_USERNAME');
        }

        if (empty($api_key)) {
            throw new TelegramException('API Key is required');
        }

        DotEnv::put('TG_CURRENT_KEY', ($this->api_key = $api_key));
        DotEnv::put('TELEGRAM_API_KEY', ($this->api_key = $api_key));
        DotEnv::put('TELEGRAM_BOT_USERNAME', ($this->bot_username = $bot_username));
    }

    /**
     * Set custom input string for debug purposes
     *
     * @param string $input (json format)
     * @return Telegram
     */
    public function setCustomInput(string $input): Telegram
    {
        $this->custom_input = $input;
        return $this;
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
     * Get Bot name
     *
     * @return string
     */
    public function getBotUsername(): string
    {
        return $this->bot_username;
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
     * Process bot Update request
     *
     * @param string $input
     * @return Update|false
     */
    public function processUpdate(string $input): Update|false
    {
        if ($this->custom_input) {
            $input = $this->custom_input;
        }

        if ($input === '' || Utils::isJson($input) === false) {
            throw new TelegramException('Input is empty!');
        }

        $update = new Update(json_decode($input, true));

        if (!$update->isOk()) return false;

        return $update;
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

}