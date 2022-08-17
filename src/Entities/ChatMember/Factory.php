<?php

namespace TelegramBot\Entities\ChatMember;

use TelegramBot\Entity;

class Factory extends \TelegramBot\Factory
{

    public static function make(array $data): Entity
    {
        $type = [
            'creator' => ChatMemberOwner::class,
            'administrator' => ChatMemberAdministrator::class,
            'member' => ChatMemberMember::class,
            'restricted' => ChatMemberRestricted::class,
            'left' => ChatMemberLeft::class,
            'kicked' => ChatMemberBanned::class,
        ];

        if (!isset($type[$data['status'] ?? ''])) {
            return new ChatMemberNotImplemented($data);
        }

        $class = $type[$data['status']];
        return new $class($data);
    }

}
