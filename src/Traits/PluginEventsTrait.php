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
        yield $update;
    }

    public function onMessage(int $update_id, Message $message): \Generator
    {
        yield $update_id;
        yield $message;
    }

    public function onEditedMessage(int $update_id, EditedMessage $editedMessage): \Generator
    {
        yield $update_id;
        yield $editedMessage;
    }

    public function onChannelPost(int $update_id, ChannelPost $channelPost): \Generator
    {
        yield $update_id;
        yield $channelPost;
    }

    public function onEditedChannelPost(int $update_id, EditedChannelPost $editedChannelPost): \Generator
    {
        yield $update_id;
        yield $editedChannelPost;
    }

    public function onInlineQuery(int $update_id, InlineQuery $inlineQuery): \Generator
    {
        yield $update_id;
        yield $inlineQuery;
    }

    public function onChosenInlineResult(int $update_id, ChosenInlineResult $chosenInlineResult): \Generator
    {
        yield $update_id;
        yield $chosenInlineResult;
    }

    public function onCallbackQuery(int $update_id, CallbackQuery $callbackQuery): \Generator
    {
        yield $update_id;
        yield $callbackQuery;
    }

    public function onShippingQuery(int $update_id, ShippingQuery $shippingQuery): \Generator
    {
        yield $update_id;
        yield $shippingQuery;
    }

    public function onPreCheckoutQuery(int $update_id, PreCheckoutQuery $preCheckoutQuery): \Generator
    {
        yield $update_id;
        yield $preCheckoutQuery;
    }

    public function onPoll(int $update_id, Poll $poll): \Generator
    {
        yield $update_id;
        yield $poll;
    }

    public function onPollAnswer(int $update_id, PollAnswer $pollAnswer): \Generator
    {
        yield $update_id;
        yield $pollAnswer;
    }

    public function onWebAppData(WebAppData $webAppData): \Generator
    {
        yield $webAppData;
    }

}