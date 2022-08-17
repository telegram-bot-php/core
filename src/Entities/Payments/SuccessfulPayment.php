<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entity;

/**
 * Class SuccessfulPayment
 *
 * This object contains basic information about a successful payment.
 *
 * @link https://core.telegram.org/bots/api#successfulpayment
 *
 * @method string    getCurrency()                  Three-letter ISO 4217 currency code
 * @method int       getTotalAmount()               Total price in the smallest units of the currency (integer, not float/double).
 * @method string    getInvoicePayload()            Bot specified invoice payload
 * @method string    getShippingOptionId()          Optional. Identifier of the shipping option chosen by the user
 * @method OrderInfo getOrderInfo()                 Optional. Order info provided by the user
 * @method string    getTelegramPaymentChargeId()   Telegram payment identifier
 * @method string    getProviderPaymentChargeId()   Provider payment identifier
 **/
class SuccessfulPayment extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'order_info' => OrderInfo::class,
        ];
    }

}
