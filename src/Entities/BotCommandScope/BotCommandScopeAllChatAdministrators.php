<?php

namespace TelegramBot\Entities\BotCommandScope;

use TelegramBot\Entity;

/**
 * Class BotCommandScopeAllChatAdministrators
 *
 * @link https://core.telegram.org/bots/api#botcommandscopeallchatadministrators
 */
class BotCommandScopeAllChatAdministrators extends Entity implements BotCommandScope
{

    public function __construct(array $data = [])
    {
        $data['type'] = 'all_chat_administrators';
        parent::__construct($data);
    }

}
