<?php

namespace TelegramBot\Entities\MenuButton;

/**
 * MenuButtonCommands
 *
 * @link https://core.telegram.org/bots/api#menubuttoncommands
 *
 */
class MenuButtonCommands extends MenuButton
{

    public function __construct(array $data)
    {
        $data['type'] = 'commands';
        parent::__construct($data);
    }

}