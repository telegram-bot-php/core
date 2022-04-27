<?php

namespace TelegramBot\Tests\Unit;

use TelegramBot\Entities\Update;
use TelegramBot\Request;
use TelegramBot\Telegram;

class PluginTest extends \TelegramBot\Plugin
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

    /**
     * @param Update $update
     * @return \Generator
     */
    public function __run(Update $update): \Generator
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