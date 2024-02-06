<?php declare(strict_types=1);

namespace TelegramBotTest\Methods;

use TelegramBot\Request;
use TelegramBot\Telegram;
use TelegramBotTest\TelegramTest;

class SendPhotoTest extends \PHPUnit\Framework\TestCase {

    public function test_send_photo_by_path(): void {
        TelegramTest::loadEnvironment();
        Telegram::setToken($_ENV['TELEGRAM_BOT_TOKEN']);

        $requestData = [
            'chat_id' => $_ENV['TEST_USER_ID'],
            'photo' => __DIR__ . '/../../logo.png'
        ];

        $request = Request::create('sendPhoto', $requestData);

        $this->assertEquals('https://api.telegram.org/bot' . $_ENV['TELEGRAM_BOT_TOKEN'] . '/sendPhoto', $request['url']);

        $response = Request::send('sendPhoto', $requestData);

        $this->assertTrue($response->isOk());
    }

}