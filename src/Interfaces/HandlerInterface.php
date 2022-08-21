<?php
declare(strict_types=1);

namespace TelegramBot\Interfaces;

use TelegramBot\Entities\Update;

/**
 * HandlerInterface class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
interface HandlerInterface
{

    /**
     * Use this method on the webhook class to get the updates
     *
     * @param Update $update
     * @return void
     */
    public function __process(Update $update): void;

}