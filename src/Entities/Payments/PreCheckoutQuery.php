<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entities\Response;
use TelegramBot\Entities\User;
use TelegramBot\Entity;
use TelegramBot\Request;

/**
 * Class PreCheckoutQuery
 *
 * This object contains information about an incoming pre-checkout query.
 *
 * @link https://core.telegram.org/bots/api#precheckoutquery
 *
 * @method string    getId()                Unique query identifier
 * @method User      getFrom()              User who sent the query
 * @method string    getCurrency()          Three-letter ISO 4217 currency code
 * @method int       getTotalAmount()       Total price in the smallest units of the currency (integer, not float/double).
 * @method string    getInvoicePayload()    Bot specified invoice payload
 * @method string    getShippingOptionId()  Optional. Identifier of the shipping option chosen by the user
 * @method OrderInfo getOrderInfo()         Optional. Order info provided by the user
 **/
class PreCheckoutQuery extends Entity
{

    /**
     * Answer this pre-checkout query.
     *
     * @param bool $ok
     * @param array $data
     *
     * @return Response
     */
    public function answer(bool $ok, array $data = []): Response
    {
        return Request::answerPreCheckoutQuery(array_merge([
            'pre_checkout_query_id' => $this->getId(),
            'ok' => $ok,
        ], $data));
    }

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'from' => User::class,
            'order_info' => OrderInfo::class,
        ];
    }

}
