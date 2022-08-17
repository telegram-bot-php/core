<?php

namespace TelegramBot\Entities\TelegramPassport\PassportElementError;

use TelegramBot\Entity;

/**
 * Class PassportElementErrorUnspecified
 *
 * Represents an issue in an unspecified place. The error is considered resolved when new data is added.
 *
 * @link https://core.telegram.org/bots/api#passportelementerrorunspecified
 *
 * @method string getSource()       Error source, must be unspecified
 * @method string getType()         Type of element of the user's Telegram Passport which has the issue
 * @method string getElementHash()  Base64-encoded element hash
 * @method string getMessage()      Error message
 */
class PassportElementErrorUnspecified extends Entity implements PassportElementError
{

    /**
     * PassportElementErrorUnspecified constructor
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $data['source'] = 'unspecified';
        parent::__construct($data);
    }

}
