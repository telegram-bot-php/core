<?php

namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class Document
 *
 * @link https://core.telegram.org/bots/api#document
 *
 * @method string    getFileId()        Identifier for this file, which can be used to download or reuse the file
 * @method string    getFileUniqueId()  Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @method PhotoSize getThumb()         Optional. Document thumbnail as defined by sender
 * @method string    getFileName()      Optional. Original filename as defined by sender
 * @method string    getMimeType()      Optional. MIME type of the file as defined by sender
 * @method int       getFileSize()      Optional. File size
 */
class Document extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }

}
