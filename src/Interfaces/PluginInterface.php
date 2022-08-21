<?php
declare(strict_types=1);

namespace TelegramBot\Interfaces;

use TelegramBot\Entities\Update;

interface PluginInterface
{

    /**
     * @param Update $update
     * @return void
     */
    public function __process(Update $update): void;

}