<?php
declare(strict_types=1);

namespace TelegramBotTest\Methods\examples\EchoBot;

use TelegramBot\Entities\Update;
use TelegramBotTest\Examples\EchoBot\Plugins\MainPlugin;

class Handler extends \TelegramBot\UpdateHandler
{

    /**
     * @inheritDoc
     */
    public function __process(Update $update): void
    {
        self::addPlugins([
            new MainPlugin(),
        ]);
    }

}