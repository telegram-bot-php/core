<?php

namespace TelegramBot\Interfaces;

use TelegramBot\Entities\Update;

class UpdateTypes
{

    const MESSAGE = 'Message';
    const EDITED_MESSAGE = 'EditedMessage';
    const CHANNEL_POST = 'ChannelPost';
    const EDITED_CHANNEL_POST = 'EditedChannelPost';
    const INLINE_QUERY = 'InlineQuery';
    const CHOSEN_INLINE_RESULT = 'ChosenInlineResult';
    const CALLBACK_QUERY = 'CallbackQuery';
    const SHIPPING_QUERY = 'ShippingQuery';
    const PRE_CHECKOUT_QUERY = 'PreCheckoutQuery';
    const POLL = 'Poll';
    const POLL_ANSWER = 'PollAnswer';
    const UNKNOWN = 'Unknown';

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
        $reflection = new \ReflectionClass(__CLASS__);
        $methods = $reflection->getConstants();

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