<?php

namespace TelegramBot\Tests\Unit;

use TelegramBot\Entities\Update;
use TelegramBot\Request;
use TelegramBot\Telegram;

class WebhookTest extends \TelegramBot\WebhookHandler
{

    public function __process(Update $update): void
    {
        if ($update->getMessage()->getText() === '/start') {
            Request::sendMessage([
                'chat_id' => $update->getMessage()->getChat()->getId(),
                'text' => 'Say hello with /hello',
            ]);
        }

        self::addPlugin([
            'hello' => PluginTest::class,
            'goodbye' => PluginWithTypeTest::class,
        ]);

        self::loadPlugins();
    }

}

$Telegram = new Telegram('123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11');
$Telegram->fetchWith(new WebhookTest());