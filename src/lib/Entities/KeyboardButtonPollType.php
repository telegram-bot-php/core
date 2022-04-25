<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class KeyboardButtonPollType
 *
 * This entity represents type of a poll, which is allowed to be created and sent when the corresponding button is pressed.
 *
 * @link https://core.telegram.org/bots/api#keyboardbutton
 *
 * @method string getType() Optional. If 'quiz' is passed, the user will be allowed to create only polls in the quiz mode. If 'regular' is passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type.
 *
 * @method $this setType(string $type) Optional. If 'quiz' is passed, the user will be allowed to create only polls in the quiz mode. If 'regular' is passed, only regular polls will be allowed. Otherwise, the user will be allowed to create a poll of any type.
 */
class KeyboardButtonPollType extends Entity
{

}
