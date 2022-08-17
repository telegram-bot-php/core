<?php

namespace TelegramBot\Entities\TelegramPassport;

use TelegramBot\Entity;

/**
 * Class PassportData
 *
 * Contains information about Telegram Passport data shared with the bot by the user.
 *
 * @link https://core.telegram.org/bots/api#passportdata
 *
 * @method EncryptedPassportElement[] getData()         Array with information about documents and other Telegram Passport elements that was shared with the bot
 * @method EncryptedCredentials       getCredentials()  Encrypted credentials required to decrypt the data
 **/
class PassportData extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'data' => [EncryptedPassportElement::class],
            'credentials' => EncryptedCredentials::class,
        ];
    }

}
