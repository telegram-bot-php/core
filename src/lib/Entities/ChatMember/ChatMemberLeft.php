<?php

namespace TelegramBot\Entities\ChatMember;

use TelegramBot\Entity;
use TelegramBot\Entities\User;

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
