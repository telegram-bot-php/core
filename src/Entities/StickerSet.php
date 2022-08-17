<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class StickerSet
 *
 * @link https://core.telegram.org/bots/api#stickerset
 *
 * @method string    getName()          Sticker set name
 * @method string    getTitle()         Sticker set title
 * @method bool      getIsAnimated()    True, if the sticker set contains animated stickers
 * @method bool      getContainsMasks() True, if the sticker set contains masks
 * @method Sticker[] getStickers()      List of all set stickers
 * @method PhotoSize getThumb()         Optional. Sticker set thumbnail in the .WEBP or .TGS format
 */
class StickerSet extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'stickers' => [Sticker::class],
            'thumb' => PhotoSize::class,
        ];
    }

}
