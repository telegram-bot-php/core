<?php

namespace TelegramBot\Entities;

/**
 * Class InlineKeyboard
 *
 * @link https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
class InlineKeyboard extends Keyboard
{

    /**
     * Creates instance of Keyboard
     *
     * @return InlineKeyboard
     */
    public static function make(): InlineKeyboard
    {
        return new self([]);
    }

}
