<?php
declare(strict_types=1);

namespace TelegramBotTest\Examples\EchoBot\Plugins;

use PHPUnit\Framework\Assert;
use TelegramBot\Entities\Message;

class MainPlugin extends \TelegramBot\Plugin {

    public function onMessage(int $update_id, Message $message): \Generator {
        Assert::assertEquals('Hello World!', $message->getText());
        Assert::assertEquals(1, $update_id);
        yield;
    }

}
