<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entity;

/**
 * Class ShippingOption
 *
 * This object represents one shipping option.
 *
 * @link https://core.telegram.org/bots/api#shippingoption
 *
 * @method string         getId()       Shipping option identifier
 * @method string         getTitle()    Option title
 * @method LabeledPrice[] getPrices()   List of price portions
 **/
class ShippingOption extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'prices' => [LabeledPrice::class],
        ];
    }

}
