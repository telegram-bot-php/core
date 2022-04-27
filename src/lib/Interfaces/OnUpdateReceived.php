<?php

namespace TelegramBot\Interfaces;

use TelegramBot\Entities\Update;

/**
 * Class OnUpdateReceived
 *
 * By implementing this interface on your plugins, you can receive updates with update types.
 *
 * @link    https://github.com/shahradelahi/telegram-bot
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/telegram-bot/blob/master/LICENSE (MIT License)
 */
interface OnUpdateReceived
{

    /**
     * This method will be called when an update is received from private chat.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onPrivateChat(Update $update): \Generator;

    /**
     * This method will be called when an update is received from group chat.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onGroupChat(Update $update): \Generator;

    /**
     * This method will be called when an update is received from channel chat.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onChannelChat(Update $update): \Generator;

    /**
     * This method will be called when an update is received from inline query.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onInlineQuery(Update $update): \Generator;

    /**
     * This method will be called when an update is received from chosen inline result.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onChosenInlineResult(Update $update): \Generator;

    /**
     * This method will be called when an update is received from callback query.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onCallbackQuery(Update $update): \Generator;

    /**
     * This method will be called when an update is received from shipping query.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onShippingQuery(Update $update): \Generator;

    /**
     * This method will be called when an update is received from pre checkout query.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onPreCheckoutQuery(Update $update): \Generator;

    /**
     * This method will be called when an update is received from poll.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onPoll(Update $update): \Generator;

    /**
     * This method will be called when an update is received from poll answer.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onPollAnswer(Update $update): \Generator;

    /**
     * This method will be called when an update is received from edited message.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onEditedMessage(Update $update): \Generator;

    /**
     * This method will be called when an update is received from edited channel post.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onEditedChannelPost(Update $update): \Generator;

    /**
     * This method will be called when an update is received from edited inline message.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onEditedInlineMessage(Update $update): \Generator;

    /**
     * This method will be called when an update is received from callback query answer.
     *
     * @param Update $update
     * @return \Generator
     */
    public function onCallbackQueryAnswer(Update $update): \Generator;

}