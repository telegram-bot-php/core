<?php

namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class Contact
 *
 * @link https://core.telegram.org/bots/api#contact
 *
 * @method string getPhoneNumber()  Contact's phone number
 * @method string getFirstName()    Contact's first name
 * @method string getLastName()     Optional. Contact's last name
 * @method int    getUserId()       Optional. Contact's user identifier in Telegram
 * @method string getVcard()        Optional. Additional data about the contact in the form of a vCard
 */
class Contact extends Entity
{

}
