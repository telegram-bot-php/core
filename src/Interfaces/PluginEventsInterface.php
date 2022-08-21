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
    public function onUpdate(Update $update): \Generator;

    /**
     * @param int $update_id
     * @param Message $message
     * @return \Generator
     */
    public function onMessage(int $update_id, Message $message): \Generator;

    /**
     * @param int $update_id
     * @param EditedMessage $editedMessage
     * @return \Generator
     */
    public function onEditedMessage(int $update_id, EditedMessage $editedMessage): \Generator;

    /**
     * @param int $update_id
     * @param ChannelPost $channelPost
     * @return \Generator
     */
    public function onChannelPost(int $update_id, ChannelPost $channelPost): \Generator;

    /**
     * @param int $update_id
     * @param EditedChannelPost $editedChannelPost
     * @return \Generator
     */
    public function onEditedChannelPost(int $update_id, EditedChannelPost $editedChannelPost): \Generator;

    /**
     * @param int $update_id
     * @param InlineQuery $inlineQuery
     * @return \Generator
     */
    public function onInlineQuery(int $update_id, InlineQuery $inlineQuery): \Generator;

    /**
     * @param int $update_id
     * @param ChosenInlineResult $chosenInlineResult
     * @return \Generator
     */
    public function onChosenInlineResult(int $update_id, ChosenInlineResult $chosenInlineResult): \Generator;

    /**
     * @param int $update_id
     * @param CallbackQuery $callbackQuery
     * @return \Generator
     */
    public function onCallbackQuery(int $update_id, CallbackQuery $callbackQuery): \Generator;

    /**
     * @param int $update_id
     * @param ShippingQuery $shippingQuery
     * @return \Generator
     */
    public function onShippingQuery(int $update_id, ShippingQuery $shippingQuery): \Generator;

    /**
     * @param int $update_id
     * @param PreCheckoutQuery $preCheckoutQuery
     * @return \Generator
     */
    public function onPreCheckoutQuery(int $update_id, PreCheckoutQuery $preCheckoutQuery): \Generator;

    /**
     * @param int $update_id
     * @param Poll $poll
     * @return \Generator
     */
    public function onPoll(int $update_id, Poll $poll): \Generator;

    /**
     * @param int $update_id
     * @param PollAnswer $pollAnswer
     * @return \Generator
     */
    public function onPollAnswer(int $update_id, PollAnswer $pollAnswer): \Generator;

    /**
     * @param int $update_id
     * @param WebAppData $webAppData
     * @return \Generator
     */
    public function onWebAppData(int $update_id, WebAppData $webAppData): \Generator;

}