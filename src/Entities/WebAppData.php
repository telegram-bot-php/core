<?php

namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class WebAppData
 *
 * Contains data sent from a Web App to the bot.
 *
 * @link https://core.telegram.org/bots/api#webappdata
 *
 * @method string getData()         The data. Be aware that a bad client can send arbitrary data in this field.
 * @method string getButtonText()   Text of the web_app keyboard button, from which the Web App was opened. Be aware that a bad client can send arbitrary data in this field.
 *
 * @method User   getUser()     (Optional). The user who sent the query.
 * @method string getHash()     (Optional). Unique identifier for the validating
 **/
class WebAppData extends Entity
{

    /**
     * {@inheritdoc}
     */
    protected function subEntities(): array
    {
        return [
            'user' => User::class,
        ];
    }

}
