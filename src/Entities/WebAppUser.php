<?php

namespace TelegramBot\Entities;

/**
 * Class WebAppUser
 *
 * @link https://core.telegram.org/bots/webapps#webappuser
 *
 * @method string getUserId()           A unique identifier for the user or bot. This number may have more than 32 significant bits and some programming languages may have difficulty/silent defects in interpreting it. It has at most 52 significant bits, so a 64-bit integer or a double-precision float type is safe for storing this identifier.
 * @method bool   getIsBot()            Optional. True, if this user is a bot. Returns in the receiver field only.
 * @method string getFirstName()        First name of the user or bot.
 * @method string getLastName()         Optional. Last name of the user or bot.
 * @method string getUsername()         Optional. Username of the user or bot.
 * @method string getLanguageCode()     Optional. IETF language tag of the user's language.
 * @method string getPhotoUrl()         Optional. URL of the user’s profile photo. The photo can be in .jpeg or .svg formats. Only returned for Web Apps launched from the attachment menu.
 */
class WebAppUser extends \TelegramBot\Entity
{

}