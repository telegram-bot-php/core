<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;
use TelegramBot\Interfaces\PluginEventsInterface;
use TelegramBot\Interfaces\PluginInterface;
use TelegramBot\Traits\PluginEventsTrait;
use TelegramBot\Traits\PluginTrait;

/**
 * Plugin class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class Plugin implements PluginEventsInterface, PluginInterface
{

    use PluginTrait;
    use PluginEventsTrait;

    public function __process(Update $update): void
    {
        // TODO: Implement __process() method.
    }

    /**
     * Kill the plugin.
     *
     * @return void
     */
    protected function stop(): void
    {
        $this->hook->stop();
    }

}
