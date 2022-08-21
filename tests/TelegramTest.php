<?php
declare(strict_types=1);

namespace TelegramBotTest;

use Symfony\Component\Dotenv\Dotenv;

class TelegramTest extends \PHPUnit\Framework\TestCase
{

    public static function loadEnvironment(): void
    {
        (new Dotenv)->load(__DIR__ . '/../.env.example');
        if (file_exists(__DIR__ . '/../.env')) {
            (new Dotenv)->load(__DIR__ . '/../.env');
        }
    }

    public function test_nothing()
    {
        $this->assertTrue(true);
    }

}