<?php
declare(strict_types=1);

namespace TelegramBotTest\Unit;

use TelegramBot\Request;
use TelegramBot\Telegram;
use TelegramBot\Util\DotEnv;

class RequestTest extends \PHPUnit\Framework\TestCase
{

    public function test_request_creation(): void
    {
        $result = Request::create('sendMessage', [
            'chat_id' => '259760855',
            'text' => 'text',
            'parse_mode' => 'Markdown',
        ], 'SOME_TOKEN');

        $expected = [
            'url' => 'https://api.telegram.org/botSOME_TOKEN/sendMessage',
            'options' => [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                    'User-Agent' => 'TelegramBot-PHP/v1.0.0'
                ],
                'query' => [
                    'chat_id' => '259760855',
                    'text' => 'text',
                    'parse_mode' => 'Markdown',
                ],
            ],
        ];

        $this->assertEquals($expected, $result);
    }

}