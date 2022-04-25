<?php

namespace TelegramBot\Tests\Unit;

use TelegramBot\Entities\Update;
use TelegramBot\Request;
use TelegramBot\Telegram;

class PluginTest extends \TelegramBot\Plugin
{

    private function __construct(Telegram $telegram)
    {
        // initialize or do something
    }

    public function __run(Update $update): \Generator
    {
        yield Request::sendMessage([
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text' => $this->getHello($update->getMessage()->getFrom()->getFirstName()),
        ]);
    }

    /**
     * @param string $name
     * @return string
     */
    private function getHello(string $name): string
    {
        return 'Hello, ' . $name;
    }

}