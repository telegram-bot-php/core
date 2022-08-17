<?php
declare(strict_types=1);

namespace TelegramBotTest;

use TelegramBot\Request;

class RequestTest extends \PHPUnit\Framework\TestCase
{

    private function load_env()
    {
        $env = file_get_contents(__DIR__ . '/../.env');
        $env = explode("\n", $env);
        foreach ($env as $line) {
            $line = explode('=', $line);
            if (count($line) == 2) {
                putenv($line[0] . '=' . $line[1]);
            }
        }
    }

    public function test_send_message()
    {
        $this->load_env();

        $result = Request::sendMessage([
            'chat_id' => '259760855',
            'text' => 'text',
            'parse_mode' => 'Markdown',
        ], getenv('TELEGRAM_BOT_TOKEN'));

        $this->assertEquals(true, $result->isOk());
    }

}