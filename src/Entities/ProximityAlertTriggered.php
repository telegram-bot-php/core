<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class ProximityAlertTriggered
 *
 * Represents the content of a service message, sent whenever a user in the chat triggers a proximity alert set by another user.
 *
 * @link https://core.telegram.org/bots/api#proximityalerttriggered
 *
 * @method User getTraveler() User that triggered the alert
 * @method User getWatcher()  User that set the alert
 * @method int  getDistance() The distance between the users
 */
class ProximityAlertTriggered extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'traveler' => User::class,
            'watcher' => User::class,
        ];
    }

}
