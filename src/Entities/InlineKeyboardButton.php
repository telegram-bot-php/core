<?php

namespace TelegramBot\Entities;

use TelegramBot\Entities\Games\CallbackGame;
use TelegramBot\Exception\TelegramException;

/**
 * Class InlineKeyboardButton
 *
 * This object represents one button of an inline keyboard. You must use exactly one of the optional fields.
 *
 * @link https://core.telegram.org/bots/api#inlinekeyboardbutton
 *
 * @method string       getText()                           Label text on the button
 * @method string       getUrl()                            Optional. HTTP url to be opened when button is pressed
 * @method LoginUrl     getLoginUrl()                       Optional. An HTTP URL used to automatically authorize the user. Can be used as a replacement for the Telegram Login Widget.
 * @method string       getCallbackData()                   Optional. Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
 * @method WebAppInfo   getWebApp()                         Optional. Description of the Web App that will be launched when the user presses the button. The Web App will be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery. Available only in private chats between a user and the bot.
 * @method string       getSwitchInlineQuery()              Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot's username and the specified inline query in the input field. Can be empty, in which case just the bot’s username will be inserted.
 * @method string       getSwitchInlineQueryCurrentChat()   Optional. If set, pressing the button will insert the bot‘s username and the specified inline query in the current chat's input field. Can be empty, in which case only the bot’s username will be inserted.
 * @method CallbackGame getCallbackGame()                   Optional. Description of the game that will be launched when the user presses the button.
 * @method bool         getPay()                            Optional. Specify True, to send a Pay button.
 *
 * @method InlineKeyboardButton setText(string $text)                                                       Label text on the button
 * @method InlineKeyboardButton setLoginUrl(LoginUrl $login_url)                                            Optional. HTTP url to be opened when button is pressed
 * @method InlineKeyboardButton setSwitchInlineQuery(string $switch_inline_query)                           Optional. If set, pressing the button will prompt the user to select one of their chats, open that chat and insert the bot's username and the specified inline query in the input field. Can be empty, in which case just the bot’s username will be inserted.
 * @method InlineKeyboardButton setSwitchInlineQueryCurrentChat(string $switch_inline_query_current_chat)   Optional. If set, pressing the button will insert the bot‘s username and the specified inline query in the current chat's input field. Can be empty, in which case only the bot’s username will be inserted.
 * @method InlineKeyboardButton setCallbackGame(CallbackGame $callback_game)                                Optional. Description of the game that will be launched when the user presses the button.
 * @method InlineKeyboardButton setPay(bool $pay)                                                           Optional. Specify True, to send a Pay button.
 */
class InlineKeyboardButton extends KeyboardButton
{

    /**
     * Creates instance of InlineKeyboardButton
     *
     * @param string $string
     * @return InlineKeyboardButton
     */
    public static function make(string $string): InlineKeyboardButton
    {
        return new self($string);
    }

    /**
     * Check if the passed data array could be an InlineKeyboardButton.
     *
     * @param array $data
     *
     * @return bool
     */
    public static function couldBe(array $data): bool
    {
        return array_key_exists('text', $data) && (
                array_key_exists('url', $data) ||
                array_key_exists('login_url', $data) ||
                array_key_exists('callback_data', $data) ||
                array_key_exists('web_app', $data) ||
                array_key_exists('switch_inline_query', $data) ||
                array_key_exists('switch_inline_query_current_chat', $data) ||
                array_key_exists('callback_game', $data) ||
                array_key_exists('pay', $data)
            );
    }

    /**
     * Optional. Data to be sent in a callback query to the bot when button is pressed, 1-64 bytes
     *
     * @param string $data
     * @return $this
     */
    public function setCallbackData(string $data): InlineKeyboardButton
    {
        $this->raw_data['callback_data'] = $data;

        return $this;
    }

    /**
     * Optional. HTTP url to be opened when button is pressed
     *
     * @param string $data
     * @return $this
     */
    public function setUrl(string $data): InlineKeyboardButton
    {
        $this->raw_data['url'] = $data;

        return $this;
    }

    /**
     * Optional. Description of the Web App that will be launched when the user presses the button. The Web App will
     * be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery. Available only
     * in private chats between a user and the bot.
     *
     * @param string $url
     * @return $this
     */
    public function setWebApp(string $url): KeyboardButton
    {
        $this->raw_data['web_app'] = new WebAppInfo(['url' => $url]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (in_array($name, ['setUrl', 'setLoginUrl', 'setCallbackData', 'web_app', 'setSwitchInlineQuery', 'setSwitchInlineQueryCurrentChat', 'setCallbackGame', 'setPay'], true)) {
            unset($this->url, $this->login_url, $this->callback_data, $this->web_app, $this->switch_inline_query, $this->switch_inline_query_current_chat, $this->callback_game, $this->pay);
        }

        return parent::__call($name, $arguments);
    }

    /**
     * {@inheritdoc}
     */
    protected function validate(): void
    {
        if ($this->getProperty('text', '') === '') {
            throw new TelegramException('You must add some text to the button!');
        }
    }

}
