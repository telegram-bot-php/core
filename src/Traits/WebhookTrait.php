<?php
declare(strict_types=1);

namespace TelegramBot\Traits;

use TelegramBot\Entities\Response;
use TelegramBot\Exception\TelegramException;
use TelegramBot\Request;

/**
 * WebhookTrait class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
trait WebhookTrait
{

    /**
     * Set Webhook for bot
     *
     * @param string $url
     * @param array $data Optional parameters.
     * @return Response
     * @throws TelegramException
     */
    public function setWebhook(string $url, array $data = []): Response
    {
        if ($url === '') {
            throw new TelegramException('Hook url is empty!');
        }

        if (!str_starts_with($url, 'https://')) {
            throw new TelegramException('Hook url must start with https://');
        }

        $data = array_intersect_key($data, array_flip([
            'certificate',
            'ip_address',
            'max_connections',
            'allowed_updates',
            'drop_pending_updates',
        ]));
        $data['url'] = $url;

        $result = Request::setWebhook($data);

        if (!$result->isOk()) {
            throw new TelegramException(
                'Webhook was not set! Error: ' . $result->getErrorCode() . ' ' . $result->getDescription()
            );
        }

        return $result;
    }

    /**
     * Delete any assigned webhook
     *
     * @param array $data
     * @return Response
     * @throws TelegramException
     */
    public function deleteWebhook(array $data = []): Response
    {
        $result = Request::deleteWebhook($data);

        if (!$result->isOk()) {
            throw new TelegramException(
                'Webhook was not deleted! Error: ' . $result->getErrorCode() . ' ' . $result->getDescription()
            );
        }

        return $result;
    }

}