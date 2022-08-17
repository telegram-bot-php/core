<?php

namespace TelegramBot\Entities\Games;

use TelegramBot\Entities\Animation;
use TelegramBot\Entities\MessageEntity;
use TelegramBot\Entities\PhotoSize;
use TelegramBot\Entity;

/**
 * Class Game
 *
 * This object represents a game. Use BotFather to create and edit games, their short names will act as unique identifiers.
 *
 * @link https://core.telegram.org/bots/api#game
 *
 * @method string          getTitle()        Title of the game
 * @method string          getDescription()  Description of the game
 * @method PhotoSize[]     getPhoto()        Photo that will be displayed in the game message in chats.
 * @method string          getText()         Optional. Brief description of the game or high scores included in the game message. Can be automatically edited to include current high scores for the game when the bot calls setGameScore, or manually edited using editMessageText. 0-4096 characters.
 * @method MessageEntity[] getTextEntities() Optional. Special entities that appear in text, such as usernames, URLs, bot commands, etc.
 * @method Animation       getAnimation()    Optional. Animation that will be displayed in the game message in chats. Upload via BotFather
 **/
class Game extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'photo' => [PhotoSize::class],
            'text_entities' => [MessageEntity::class],
            'animation' => Animation::class,
        ];
    }

}
