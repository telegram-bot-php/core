<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;
use TelegramBot\Interfaces\OnUpdateReceived;
use TelegramBot\Interfaces\UpdateTypes;

/**
 * Class Plugin
 *
 * @link    https://github.com/shahradelahi/telegram-bot
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/telegram-bot/blob/master/LICENSE (MIT License)
 */
abstract class Plugin
{

    /**
     * @var WebhookHandler
     */
    protected WebhookHandler $hook;

    /**
     * @var \Generator
     */
    protected \Generator $returns;

    /**
     * @var bool
     */
    protected bool $kill_on_yield = false;

    /**
     * Override this method to add your own functionality
     *
     * @param Update $update
     * @return \Generator
     */
    abstract public function __run(Update $update): \Generator;

    /**
     * Execute the plugin.
     *
     * @param WebhookHandler $receiver
     * @param Update $update
     * @return void
     */
    public function __execute(WebhookHandler $receiver, Update $update): void
    {
        $this->hook = $receiver;
        $returns = $this->__run($update);

        if ($this instanceof OnUpdateReceived) {
            $this->onUpdateReceived($update);
        }

        if (!$returns->getReturn()) {
            if ($this->kill_on_yield) {
                $this->kill();
            }
        }
    }

    /**
     * Identify the update type and if method of the type is exists, execute it.
     *
     * @param Update $update
     * @return void
     */
    private function onUpdateReceived(Update $update): void
    {
        $method = UpdateTypes::identify($update);
        if (method_exists($this, $method)) {
            $this->$method($update);
        }
    }

    /**
     * Kill the plugin.
     *
     * @return void
     */
    public function kill(): void
    {
        $this->hook->kill();
    }

}