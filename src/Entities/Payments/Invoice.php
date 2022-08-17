<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entity;

/**
 * Class Invoice
 *
 * This object contains basic information about an invoice.
 *
 * @link https://core.telegram.org/bots/api#invoice
 *
 * @method string getTitle()            Product name
 * @method string getDescription()      Product description
 * @method string getStartParameter()   Unique bot deep-linking parameter that can be used to generate this invoice
 * @method string getCurrency()         Three-letter ISO 4217 currency code
 * @method int    getTotalAmount()      Total price in the smallest units of the currency (integer, not float/double).
 **/
class Invoice extends Entity
{

}
