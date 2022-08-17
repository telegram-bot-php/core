<?php

namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class VoiceChatParticipantsInvited
 *
 * Represents a service message about new members invited to a voice chat
 *
 * @link https://core.telegram.org/bots/api#voicechatparticipantsinvited
 *
 * @method User[] getUsers()    Optional. New members that were invited to the voice chat
 */
class VoiceChatParticipantsInvited extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'users' => [User::class],
        ];
    }

}
