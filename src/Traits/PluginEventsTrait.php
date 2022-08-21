<?php
declare(strict_types=1);

namespace TelegramBot\Traits;

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

trait PluginEventsTrait
{

    public function onUpdate(Update $update): \Generator
    {
        return yield;
    }

    public function onMessage(int $update_id, Message $message): \Generator
    {
        return yield;
    }

    public function onEditedMessage(int $update_id, EditedMessage $editedMessage): \Generator
    {
        return yield;
    }

    public function onChannelPost(int $update_id, ChannelPost $channelPost): \Generator
    {
        return yield;
    }

    public function onEditedChannelPost(int $update_id, EditedChannelPost $editedChannelPost): \Generator
    {
        return yield;
    }

    public function onInlineQuery(int $update_id, InlineQuery $inlineQuery): \Generator
    {
        return yield;
    }

    public function onChosenInlineResult(int $update_id, ChosenInlineResult $chosenInlineResult): \Generator
    {
        return yield;
    }

    public function onCallbackQuery(int $update_id, CallbackQuery $callbackQuery): \Generator
    {
        return yield;
    }

    public function onShippingQuery(int $update_id, ShippingQuery $shippingQuery): \Generator
    {
        return yield;
    }

    public function onPreCheckoutQuery(int $update_id, PreCheckoutQuery $preCheckoutQuery): \Generator
    {
        return yield;
    }

    public function onPoll(int $update_id, Poll $poll): \Generator
    {
        return yield;
    }

    public function onPollAnswer(int $update_id, PollAnswer $pollAnswer): \Generator
    {
        return yield;
    }

    public function onWebAppData(int $update_id, WebAppData $webAppData): \Generator
    {
        return yield;
    }

}