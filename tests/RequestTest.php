<?php
declare(strict_types=1);

namespace TelegramBotTest;

use TelegramBot\Request;

class RequestTest extends \PHPUnit\Framework\TestCase
{

    public function test_send_message()
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