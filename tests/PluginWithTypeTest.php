<?php

namespace TelegramBot\Tests\Unit;

use TelegramBot\Entities\Update;
use TelegramBot\Plugin;
use TelegramBot\Request;
use TelegramBot\Telegram;

class PluginWithTypeTest extends Plugin
{
    /**
     * Plugin constructor.
     *
     * @param Telegram $telegram
     */
    private function __construct(Telegram $telegram)
    {
        // initialize or do something
    }

    public function onPrivateChat(Update $update): \Generator
    {
        if ($update->getMessage()->getText() === '/goodbye') {
            yield Request::sendMessage([
                'chat_id' => $update->getMessage()->getChat()->getId(),
                'text' => 'Goodbye!',
            ]);
        }
    }

}