<?php
declare(strict_types=1);

namespace TelegramBot\Traits;

use TelegramBot\Entities\Response;
use TelegramBot\Entities\Update;
use TelegramBot\UpdateHandler;

/**
 * PluginTrait class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
trait PluginTrait
{

    /**
     * @var UpdateHandler
     */
    protected UpdateHandler $hook;

    /**
     * @var \Generator
     */
    private \Generator $returns;

    /**
     * This property is used to kill the plugin when you yield a Response object.
     *
     * @var bool
     */
    protected bool $KILL_ON_YIELD = true;

    /**
     * Execute the plugin.
     *
     * @param UpdateHandler $receiver
     * @param Update $update
     * @return void
     */
    public function __execute(UpdateHandler $receiver, Update $update): void
    {
        $this->hook = $receiver;

        if (method_exists($this, '__process')) {
            $this->__process($update);
        }

        if (method_exists($this, 'onReceivedUpdate')) {
            $return = $this->onUpdate($update);
            $this->__checkExit($return);
        }

        $type = $this->__identify($update);
        if (method_exists($this, ($method = 'on' . $type)) && $type !== null) {
            $catchMethod = 'get' . ucfirst($type);
            $return = $this->$method($update->getUpdateId(), $update->$catchMethod());
            $this->__checkExit($return);
        }
    }

    /**
     * Check for the exit of the plugin.
     *
     * @param \Generator $return
     * @return void
     */
    private function __checkExit(\Generator $return): void
    {
        if ($return->valid()) {
            if ($return->current() !== null && $this->KILL_ON_YIELD === true) {
                if ($return->current() instanceof Response) {
                    $this->stop();
                }
            }
        }

        if ($return->valid()) {
            $return->next();
            $this->__checkExit($return);
        }
    }

    /**
     * Identify the update type. e.g. Message, EditedMessage, etc.
     *
     * @param Update $update
     * @return string|null
     */
    private function __identify(Update $update): ?string
    {
        $type = $update->getUpdateType();

        if ($type === null) {
            return null;
        }

        return str_replace('_', '', ucwords($type, '_'));
    }

}