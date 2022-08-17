<?php

namespace TelegramBot\Entities\ChatMember;

use TelegramBot\Entities\User;
use TelegramBot\Entity;

/**
 * Class ChatMemberNotImplemented
 *
 * @method string getStatus()   The member's status in the chat
 * @method User   getUser()     Information about the user
 */
class ChatMemberNotImplemented extends Entity implements ChatMember
{

}
