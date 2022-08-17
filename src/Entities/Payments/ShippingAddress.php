<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entity;

/**
 * Class ShippingAddress
 *
 * This object represents a shipping address.
 *
 * @link https://core.telegram.org/bots/api#shippingaddress
 *
 * @method string getCountryCode()  ISO 3166-1 alpha-2 country code
 * @method string getState()        State, if applicable
 * @method string getCity()         City
 * @method string getStreetLine1()  First line for the address
 * @method string getStreetLine2()  Second line for the address
 * @method string getPostCode()     Address post code
 **/
class ShippingAddress extends Entity
{

}
