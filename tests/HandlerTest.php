<?php
declare(strict_types=1);

namespace TelegramBotTest;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;
use TelegramBot\Entities\Update;
use TelegramBot\Plugin;
use TelegramBot\Request;
use TelegramBot\Telegram;
use TelegramBot\UpdateHandler;
use TelegramBotTest\EchoBot\Handler;

class HandlerTest extends \PHPUnit\Framework\TestCase
{

    public function test_echo_bot(): void
    {
        (new Handler())->resolve(Telegram::processUpdate(
            '{"update_id":1,"message":{"message_id":1,"from":{"id":1,"is_bot":false,"first_name":"First","last_name":"Last","username":"username","language_code":"en"},"chat":{"id":1,"first_name":"First","last_name":"Last","username":"username","type":"private"},"date":1546300800,"text":"Hello World!"}}',
            '1234567890:ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
        ));

        $this->assertTrue(true);
    }

    public function test_single_plugin(): void
    {
        $plugin = new class($this) extends Plugin {

            public function __construct(private TestCase $class)
            {

            }

            public function __process(Update $update): void
            {
                $this->class->assertEquals(1, $update->getUpdateId());
            }

        };

        (new Dotenv)->load(__DIR__ . '/../.env.example');
        (new UpdateHandler())->addPlugins($plugin)->resolve(Telegram::processUpdate(
            '{"update_id":1,"message":{"message_id":1,"from":{"id":1,"is_bot":false,"first_name":"First","last_name":"Last","username":"username","language_code":"en"},"chat":{"id":1,"first_name":"First","last_name":"Last","username":"username","type":"private"},"date":1546300800,"text":"Hello World!"}}',
            $_ENV['TELEGRAM_BOT_TOKEN']
        ));
    }

}