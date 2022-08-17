<?php

namespace TelegramBot\Entities\ChatMember;

use TelegramBot\Entities\User;
use TelegramBot\Entity;

/**
 * Class ChatMemberLeft
 *
 * @link https://core.telegram.org/bots/api#chatmemberleft
 *
 * @method string getStatus()   The member's status in the chat, always “left”
 * @method User   getUser()     Information about the user
 */
class ChatMemberLeft extends Entity implements ChatMember
{

    /**
     * @inheritDoc
     */
    protected function subEntities(): array
    {
        return [
            'user' => User::class,
        ];
    }

}
