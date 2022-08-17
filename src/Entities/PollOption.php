<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class PollOption
 *
 * This entity contains information about one answer option in a poll.
 *
 * @link https://core.telegram.org/bots/api#polloption
 *
 * @method string getText()       Option text, 1-100 characters
 * @method int    getVoterCount() Number of users that voted for this option
 */
class PollOption extends Entity
{

}
