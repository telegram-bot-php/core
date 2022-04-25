<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;

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
     * @var Receiver
     */
    protected Receiver $receiver;

    /**
     * @var \Generator
     */
    protected \Generator $returns;

    /**
     * @var bool
     */
    protected bool $kill_on_finish = false;

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
     * @param Receiver $receiver
     * @param Update $update
     * @return void
     */
    public function __execute(Receiver $receiver, Update $update): void
    {
        $this->receiver = $receiver;
        $returns = $this->__run($update);
        if (!$returns->getReturn()) {
            if ($this->kill_on_finish) {
                $this->kill();
            }
        }
    }

    /**
     * Kill the plugin.
     *
     * @return void
     */
    public function kill(): void
    {
        $this->receiver->kill();
    }

}