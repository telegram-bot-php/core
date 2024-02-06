<?php
declare(strict_types=1);

namespace TelegramBotTest\Examples\EchoBot\Plugins;

use TelegramBot\Entities\Message;

class MainPlugin extends \TelegramBot\Plugin {

    public function onMessage(int $updateId, Message $message): \Generator {
        echo "UpdateId: " . $updateId . ", Text: " . $message->getText();
        yield;
    }

}