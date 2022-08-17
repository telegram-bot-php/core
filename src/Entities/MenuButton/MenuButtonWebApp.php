<?php

namespace TelegramBot\Entities\MenuButton;

use TelegramBot\Entities\WebAppInfo;

/**
 * MenuButtonWebApp
 *
 * Represents a menu button, which launches a Web App.
 *
 * @link https://core.telegram.org/bots/api#menubuttonwebapp
 *
 * @method string     getText()         Text on the button
 * @method string     getWebApp()       Description of the Web App that will be launched when the user presses the button. The Web App will be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery.
 *
 * @method $this setText(string $text)          Text on the button
 * @method $this setWebApp(WebAppInfo $web_app) Description of the Web App that will be launched when the user presses the button. The Web App will be able to send an arbitrary message on behalf of the user using the method answerWebAppQuery.
 */
class MenuButtonWebApp
{

}