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
 * @method string    getData()          The data. Be aware that a bad client can send arbitrary data in this field.
 * @method string    getButtonText()    Text of the web_app keyboard button, from which the Web App was opened. Be aware that a bad client can send arbitrary data in this field.
 **/
class WebAppData extends Entity
{

}
