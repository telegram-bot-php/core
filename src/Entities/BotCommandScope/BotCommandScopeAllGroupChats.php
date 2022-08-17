<?php

namespace TelegramBot\Entities\BotCommandScope;

use TelegramBot\Entity;

/**
 * Class BotCommandScopeAllGroupChats
 *
 * @link https://core.telegram.org/bots/api#botcommandscopeallgroupchats
 */
class BotCommandScopeAllGroupChats extends Entity implements BotCommandScope
{

    public function __construct(array $data = [])
    {
        $data['type'] = 'all_group_chats';
        parent::__construct($data);
    }

}
