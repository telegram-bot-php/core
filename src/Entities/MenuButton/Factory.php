<?php

namespace TelegramBot\Entities\MenuButton;

use TelegramBot\Entity;

class Factory extends \TelegramBot\Factory
{

    public static function make(array $data): Entity
    {
        $type = [
            'commands' => MenuButtonCommands::class,
            'web_app' => MenuButtonWebApp::class,
            'default' => MenuButtonDefault::class,
        ];

        if (!isset($type[$data['type'] ?? ''])) {
            return new MenuButtonNotImplemented($data);
        }

        $class = $type[$data['type']];
        return new $class($data);
    }

}
