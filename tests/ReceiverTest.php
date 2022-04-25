<?php

namespace TelegramBot\Tests\Unit;

use TelegramBot\Entities\Update;
use TelegramBot\Request;

class ReceiverTest extends \TelegramBot\Receiver
{

    public function __process(Update $update): void
    {
        Request::sendMessage([
            'chat_id' => $update->getMessage()->getChat()->getId(),
            'text' => 'Hello World!',
        ]);
    }

}