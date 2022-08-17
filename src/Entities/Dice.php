<?php

namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class Dice
 *
 * This entity represents a dice with random value from 1 to 6.
 *
 * @link https://core.telegram.org/bots/api#dice
 *
 * @method string getEmoji()    Emoji on which the dice throw animation is based
 * @method int    getValue()    Value of the dice, 1-6 for “🎲” and “🎯” base emoji, 1-5 for “🏀” and “⚽” base emoji, 1-64 for “🎰” base emoji
 */
class Dice extends Entity
{

}
