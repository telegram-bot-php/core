<?php
declare(strict_types=1);

namespace TelegramBotTest\EchoBot\Plugins;

use TelegramBot\Entities\Message;

class MainPlugin extends \TelegramBot\Plugin
{

    public function onMessage(int $id, Message $update): \Generator
    {
        echo $update->getText();
        yield;
    }

}