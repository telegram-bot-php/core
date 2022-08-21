<?php
declare(strict_types=1);

namespace TelegramBot\Interfaces;

use TelegramBot\Entities\CallbackQuery;
use TelegramBot\Entities\ChannelPost;
use TelegramBot\Entities\ChosenInlineResult;
use TelegramBot\Entities\EditedChannelPost;
use TelegramBot\Entities\EditedMessage;
use TelegramBot\Entities\InlineQuery;
use TelegramBot\Entities\Message;
use TelegramBot\Entities\Payments\PreCheckoutQuery;
use TelegramBot\Entities\Payments\ShippingQuery;
use TelegramBot\Entities\Poll;
use TelegramBot\Entities\PollAnswer;
use TelegramBot\Entities\Update;
use TelegramBot\Entities\WebAppData;

interface PluginEventsInterface
{

    /**
     * @param Update $update
     * @return \Generator
     */
    public function onReceivedUpdate(Update $update): \Generator;

    /**
     * @param int $id
     * @param Message $update
     * @return \Generator
     */
    public function onMessage(int $id, Message $update): \Generator;

    /**
     * @param int $id
     * @param EditedMessage $update
     * @return \Generator
     */
    public function onEditedMessage(int $id, EditedMessage $update): \Generator;

    /**
     * @param int $id
     * @param ChannelPost $update
     * @return \Generator
     */
    public function onChannelPost(int $id, ChannelPost $update): \Generator;

    /**
     * @param int $id
     * @param EditedChannelPost $update
     * @return \Generator
     */
    public function onEditedChannelPost(int $id, EditedChannelPost $update): \Generator;

    /**
     * @param int $id
     * @param InlineQuery $update
     * @return \Generator
     */
    public function onInlineQuery(int $id, InlineQuery $update): \Generator;

    /**
     * @param int $id
     * @param ChosenInlineResult $update
     * @return \Generator
     */
    public function onChosenInlineResult(int $id, ChosenInlineResult $update): \Generator;

    /**
     * @param int $id
     * @param CallbackQuery $update
     * @return \Generator
     */
    public function onCallbackQuery(int $id, CallbackQuery $update): \Generator;

    /**
     * @param int $id
     * @param ShippingQuery $update
     * @return \Generator
     */
    public function onShippingQuery(int $id, ShippingQuery $update): \Generator;

    /**
     * @param int $id
     * @param PreCheckoutQuery $update
     * @return \Generator
     */
    public function onPreCheckoutQuery(int $id, PreCheckoutQuery $update): \Generator;

    /**
     * @param int $id
     * @param Poll $update
     * @return \Generator
     */
    public function onPoll(int $id, Poll $update): \Generator;

    /**
     * @param int $id
     * @param PollAnswer $update
     * @return \Generator
     */
    public function onPollAnswer(int $id, PollAnswer $update): \Generator;

    /**
     * @param int $id
     * @param WebAppData $update
     * @return \Generator
     */
    public function onWebAppData(int $id, WebAppData $update): \Generator;

}