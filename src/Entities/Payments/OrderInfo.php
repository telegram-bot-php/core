<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entity;

/**
 * Class OrderInfo
 *
 * This object represents information about an order.
 *
 * @link https://core.telegram.org/bots/api#orderinfo
 *
 * @method string          getName()                Optional. User name
 * @method string          getPhoneNumber()         Optional. User's phone number
 * @method string          getEmail()               Optional. User email
 * @method ShippingAddress getShippingAddress()     Optional. User shipping address
 **/
class OrderInfo extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'shipping_address' => ShippingAddress::class,
        ];
    }

}
