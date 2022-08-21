<?php
declare(strict_types=1);

namespace TelegramBotTest\EchoBot;

use TelegramBot\Entities\Update;
use TelegramBotTest\EchoBot\Plugins\MainPlugin;

class Handler extends \TelegramBot\UpdateHandler
{

    /**
     * @inheritDoc
     */
    public function __process(Update $update): void
    {
        self::addPlugins([
            MainPlugin::class,
        ]);
    }

}