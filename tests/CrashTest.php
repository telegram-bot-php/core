<?php
declare(strict_types=1);

namespace TelegramBotTest;

use PHPUnit\Framework\TestCase;
use TelegramBot\CrashPad;
use TelegramBot\Entities\Update;
use TelegramBot\Plugin;
use TelegramBot\Telegram;
use TelegramBot\UpdateHandler;

class CrashTest extends \PHPUnit\Framework\TestCase {

    public function test_crash(): void {
        $plugin = new class($this) extends Plugin {

            public function __construct(TestCase $testCase) {
                TelegramTest::loadEnvironment();
                Telegram::setAdminId((int)$_ENV['TEST_USER_ID']);
                $testCase->assertEquals((int)$_ENV['TEST_USER_ID'], Telegram::getAdminId());
            }

            public function __process(Update $update): void {
                CrashPad::sendCrash(
                    Telegram::getAdminId(),
                    new \Exception('test'),
                    json_encode($update->getRawData(), JSON_PRETTY_PRINT)
                );
                CrashPad::clearCrashLogs();
            }

        };

        TelegramTest::loadEnvironment();
        (new UpdateHandler())->
        addPlugins($plugin)->
        resolve(Telegram::processUpdate(
            '{"update_id":1,"message":{"message_id":1,"from":{"id":1,"is_bot":false,"first_name":"First","last_name":"Last","username":"username","language_code":"en"},"chat":{"id":1,"first_name":"First","last_name":"Last","username":"username","type":"private"},"date":1546300800,"text":"Hello World!"}}',
            $_ENV['TELEGRAM_BOT_TOKEN']
        ));
    }

}
