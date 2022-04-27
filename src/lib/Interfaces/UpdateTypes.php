<?php

namespace TelegramBot\Interfaces;

use TelegramBot\Entities\Update;

class UpdateTypes
{

    const MESSAGE = 'message';
    const EDITED_MESSAGE = 'edited_message';
    const CHANNEL_POST = 'channel_post';
    const EDITED_CHANNEL_POST = 'edited_channel_post';
    const INLINE_QUERY = 'inline_query';
    const CHOSEN_INLINE_RESULT = 'chosen_inline_result';
    const CALLBACK_QUERY = 'callback_query';
    const SHIPPING_QUERY = 'shipping_query';
    const PRE_CHECKOUT_QUERY = 'pre_checkout_query';
    const POLL = 'poll';
    const POLL_ANSWER = 'poll_answer';
    const UNKNOWN = 'unknown';

    /**
     * Find the type by value
     *
     * @param string $value
     * @return string
     */
    public static function findByValue(string $value): string
    {
        $reflection = new \ReflectionClass(__CLASS__);
        $constants = $reflection->getConstants();
        foreach ($constants as $constant) {
            if ($constant == $value) {
                return $constant;
            }
        }
        return self::UNKNOWN;
    }

    /**
     * Get type of update
     *
     * @param Update $update
     * @return string
     */
    public static function identify(Update $update): string
    {
        $methods = [
            'Message',
            'EditedMessage',
            'ChannelPost',
            'EditedChannelPost',
            'InlineQuery',
            'ChosenInlineResult',
            'CallbackQuery',
            'ShippingQuery',
            'PreCheckoutQuery',
            'Poll',
            'PollAnswer',
        ];

        foreach ($methods as $method) {
            if (method_exists($update, 'get' . $method)) {
                if (!empty($update->{'get' . $method}())) {
                    $name = preg_replace('/([A-Z])/', '_$1', lcfirst($method));
                    return self::findByValue(strtolower($name));
                }
            }
        }

        return self::UNKNOWN;
    }

}