<?php
declare(strict_types=1);

namespace TelegramBotTest;

use TelegramBot\Request;
use TelegramBot\Telegram;

class RequestTest extends \PHPUnit\Framework\TestCase
{

    public function test_request_creation(): void
    {
        TelegramTest::loadEnvironment();
        Telegram::setToken($_ENV['TELEGRAM_BOT_TOKEN']);

        $result = Request::create('sendMessage', [
            'chat_id' => '259760855',
            'text' => 'text',
            'parse_mode' => 'Markdown',
        ]);

        $expected = [
            'url' => "https://api.telegram.org/bot{$_ENV['TELEGRAM_BOT_TOKEN']}/sendMessage",
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

    public function test_send_message(): void
    {
        TelegramTest::loadEnvironment();
        Telegram::setToken($_ENV['TELEGRAM_BOT_TOKEN']);

        $response = Request::sendMessage([
            'chat_id' => 259760855,
            'text' => 'Hello World',
        ]);

        $this->assertTrue($response->isOk());
    }

}