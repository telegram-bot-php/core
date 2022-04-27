<?php

namespace TelegramBot\Tests\Unit;

use TelegramBot\Entities\Update;
use TelegramBot\Interfaces\OnUpdateReceived;
use TelegramBot\Plugin;
use TelegramBot\Request;

abstract class PluginWithTypeTest extends Plugin implements OnUpdateReceived
{

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