<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class UserProfilePhotos
 *
 * @link https://core.telegram.org/bots/api#userprofilephotos
 *
 * @method int getTotalCount() Total number of profile pictures the target user has
 */
class UserProfilePhotos extends Entity
{

    /**
     * Requested profile pictures (in up to 4 sizes each)
     *
     * This method overrides the default getPhotos method and returns a nice array
     *
     * @return PhotoSize[][]
     */
    public function getPhotos(): array
    {
        $all_photos = [];

        if ($these_photos = $this->getProperty('photos')) {
            foreach ($these_photos as $photos) {
                $all_photos[] = array_map(function ($photo) {
                    return new PhotoSize($photo);
                }, $photos);
            }
        }

        return $all_photos;
    }

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'photos' => PhotoSize::class,
        ];
    }

}
