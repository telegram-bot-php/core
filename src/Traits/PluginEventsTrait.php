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

    public function onReceivedUpdate(Update $update): \Generator
    {
        return yield;
    }

    public function onMessage(int $id, Message $update): \Generator
    {
        return yield;
    }

    public function onEditedMessage(int $id, EditedMessage $update): \Generator
    {
        return yield;
    }

    public function onChannelPost(int $id, ChannelPost $update): \Generator
    {
        return yield;
    }

    public function onEditedChannelPost(int $id, EditedChannelPost $update): \Generator
    {
        return yield;
    }

    public function onInlineQuery(int $id, InlineQuery $update): \Generator
    {
        return yield;
    }

    public function onChosenInlineResult(int $id, ChosenInlineResult $update): \Generator
    {
        return yield;
    }

    public function onCallbackQuery(int $id, CallbackQuery $update): \Generator
    {
        return yield;
    }

    public function onShippingQuery(int $id, ShippingQuery $update): \Generator
    {
        return yield;
    }

    public function onPreCheckoutQuery(int $id, PreCheckoutQuery $update): \Generator
    {
        return yield;
    }

    public function onPoll(int $id, Poll $update): \Generator
    {
        return yield;
    }

    public function onPollAnswer(int $id, PollAnswer $update): \Generator
    {
        return yield;
    }

    public function onWebAppData(int $id, WebAppData $update): \Generator
    {
        return yield;
    }

}