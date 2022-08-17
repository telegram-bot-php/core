<?php

namespace TelegramBot\Entities\TelegramPassport\PassportElementError;

use TelegramBot\Entity;

/**
 * Class PassportElementErrorDataField
 *
 * Represents an issue in one of the data fields that was provided by the user. The error is considered resolved when the field's value changes.
 *
 * @link https://core.telegram.org/bots/api#passportelementerrordatafield
 *
 * @method string getSource()       Error source, must be data
 * @method string getType()         The section of the user's Telegram Passport which has the error, one of “personal_details”, “passport”, “driver_license”, “identity_card”, “internal_passport”, “address”
 * @method string getFieldName()    Name of the data field which has the error
 * @method string getDataHash()     Base64-encoded data hash
 * @method string getMessage()      Error message
 */
class PassportElementErrorDataField extends Entity implements PassportElementError
{

    /**
     * PassportElementErrorDataField constructor
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $data['source'] = 'data';
        parent::__construct($data);
    }

}
