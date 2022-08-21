<?php

namespace TelegramBotTest;

use Symfony\Component\Dotenv\Dotenv;
use TelegramBot\Entities\Update;
use TelegramBot\Telegram;

class ProcessUpdateTest extends \PHPUnit\Framework\TestCase
{

    public function test_webhook()
    {
        $update = $this->get_fake_update();

        $this->assertEquals($update->getCallbackQuery()->getData(), 'tasks-settings');

        $this->assertEquals($update->getCallbackQuery()->getId(), '1115664380233733737');

        $this->assertEquals($update->getCallbackQuery()->getInlineMessageId(), null);
    }

    private function get_fake_update(): Update
    {
        return Telegram::processUpdate('{"update_id":226394498,"callback_query":{"id":"1115664380233733737","from":{"id":259760855,"is_bot":false,"first_name":"Shahrad","last_name":"Elahi","username":"ShahradElahi","language_code":"en"},"message":{"message_id":4071,"from":{"id":1861977284,"is_bot":true,"first_name":"Earnomi","username":"EarnomiBot"},"chat":{"id":259760855,"first_name":"Shahrad","last_name":"Elahi","username":"ShahradElahi","type":"private"},"date":1651775842,"text":"Choose an option below to change your settings","reply_markup":{"inline_keyboard":[[{"text":"Task Alerts","callback_data":"tasks-settings"}]]}},"chat_instance":"7764778060035751380","data":"tasks-settings"}}');
    }

}