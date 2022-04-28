<?php

namespace TelegramBot\Entities\Payments;

use TelegramBot\Entity;
use TelegramBot\Entities\Response;
use TelegramBot\Entities\User;
use TelegramBot\Request;

/**
 * Class ShippingQuery
 *
 * This object contains information about an incoming shipping query.
 *
 * @link https://core.telegram.org/bots/api#shippingquery
 *
 * @method string          getId()                  Unique query identifier
 * @method User            getFrom()                User who sent the query
 * @method string          getInvoicePayload()      Bot specified invoice payload
 * @method ShippingAddress getShippingAddress()     User specified shipping address
 **/
class ShippingQuery extends Entity
{
    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'from'             => User::class,
            'shipping_address' => ShippingAddress::class,
        ];
    }

    /**
     * Answer this shipping query.
     *
     * @param bool  $ok
     * @param array $data
     *
     * @return Response
     */
    public function answer(bool $ok, array $data = []): Response
    {
        return Request::answerShippingQuery(array_merge([
            'shipping_query_id' => $this->getId(),
            'ok'                => $ok,
        ], $data));
    }
}
