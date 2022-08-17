<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entity;

/**
 * Class LabeledPrice
 *
 * This object represents a portion of the price for goods or services.
 *
 * @link https://core.telegram.org/bots/api#labeledprice
 *
 * @method string getLabel()    Portion label
 * @method int    getAmount()   Price of the product in the smallest units of the currency (integer, not float/double).
 **/
class LabeledPrice extends Entity
{

}
