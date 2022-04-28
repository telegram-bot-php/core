<?php

namespace TelegramBot\Entities\TelegramPassport;

use TelegramBot\Entity;

/**
 * Class PassportFile
 *
 * This object represents a file uploaded to Telegram Passport. Currently all Telegram Passport files are in JPEG format when decrypted and don't exceed 10MB.
 *
 * @link https://core.telegram.org/bots/api#passportfile
 *
 * @method string getFileId()           Identifier for this file, which can be used to download or reuse the file
 * @method string getFileUniqueId()     Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @method int    getFileSize()         File size
 * @method int    getFileDate()         Unix time when the file was uploaded
 **/
class PassportFile extends Entity
{

}
