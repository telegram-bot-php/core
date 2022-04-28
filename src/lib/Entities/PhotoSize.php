<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class PhotoSize
 *
 * @link https://core.telegram.org/bots/api#photosize
 *
 * @method string getFileId()           Identifier for this file, which can be used to download or reuse the file
 * @method string getFileUniqueId()     Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @method int    getWidth()            Photo width
 * @method int    getHeight()           Photo height
 * @method int    getFileSize()         Optional. File size
 */
class PhotoSize extends Entity
{

}
