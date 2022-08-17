<?php

namespace TelegramBot\Entities;

use TelegramBot\Entities\ChatMember\ChatMember;
use TelegramBot\Entities\ChatMember\Factory as ChatMemberFactory;
use TelegramBot\Entity;

/**
 * Class ChatMemberUpdated
 *
 * Represents changes in the status of a chat member
 *
 * @link https://core.telegram.org/bots/api#chatmemberupdated
 *
 * @method Chat            getChat()            Chat the user belongs to
 * @method User            getFrom()            Performer of the action, which resulted in the change
 * @method int             getDate()            Date the change was done in Unix time
 * @method ChatMember      getOldChatMember()   Previous information about the chat member
 * @method ChatMember      getNewChatMember()   New information about the chat member
 * @method ChatInviteLink  getInviteLink()      Optional. Chat invite link, which was used by the user to join the chat, for joining by invite link events only.
 */
class ChatMemberUpdated extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'chat' => Chat::class,
            'from' => User::class,
            'old_chat_member' => ChatMemberFactory::class,
            'new_chat_member' => ChatMemberFactory::class,
            'invite_link' => ChatInviteLink::class,
        ];
    }

}
