<?php

namespace TelegramBot\Tests\Unit;

use TelegramBot\Entities\Update;
use TelegramBot\Request;
use TelegramBot\Telegram;

class PluginTest extends \TelegramBot\Plugin
{

    /**
     * @param Update $update
     * @return \Generator
     */
    public function OnReceivedUpdate(Update $update): \Generator
    {
        yield Request::sendMessage([
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text' => $this->getText($update->getMessage()->getFrom()->getFirstName()),
        ]);
    }

    /**
     * @param string $name
     * @return string
     */
    private function getText(string $name): string
    {
        return 'Hello, ' . $name;
    }

}