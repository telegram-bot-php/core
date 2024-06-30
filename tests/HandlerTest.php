<?php
declare(strict_types=1);

namespace TelegramBotTest;

use PHPUnit\Framework\TestCase;
use TelegramBot\Entities\Update;
use TelegramBot\Plugin;
use TelegramBot\Telegram;
use TelegramBot\UpdateHandler;
use TelegramBotTest\Examples\EchoBot\Handler;

class HandlerTest extends \PHPUnit\Framework\TestCase {

    public function test_echo_bot(): void {
            TelegramTest::loadEnvironment();
        (new Handler())->resolve(Telegram::processUpdate(
            '{"update_id":1,"message":{"message_id":1,"from":{"id":1,"is_bot":false,"first_name":"First","last_name":"Last","username":"username","language_code":"en"},"chat":{"id":1,"first_name":"First","last_name":"Last","username":"username","type":"private"},"date":1546300800,"text":"Hello World!"}}',
            $_ENV['TELEGRAM_BOT_TOKEN']
        ));

        $this->assertTrue(true);
    }

    public function test_single_plugin(): void {
        $plugin = new class($this) extends Plugin {

            public function __construct(private TestCase $class) {

            }

            public function __process(Update $update): void {
                $this->class->assertEquals(1, $update->getUpdateId());
            }

        };

        TelegramTest::loadEnvironment();

        (new UpdateHandler())->addPlugins($plugin)->resolve(Telegram::processUpdate(
            '{"update_id":1,"message":{"message_id":1,"from":{"id":1,"is_bot":false,"first_name":"First","last_name":"Last","username":"username","language_code":"en"},"chat":{"id":1,"first_name":"First","last_name":"Last","username":"username","type":"private"},"date":1546300800,"text":"Hello World!"}}',
            $_ENV['TELEGRAM_BOT_TOKEN']
        ));
    }

}
