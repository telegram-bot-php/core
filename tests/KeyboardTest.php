<?php

namespace TelegramBotTest;

use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\Keyboard;
use TelegramBot\Entities\KeyboardButton;
use TelegramBot\Request;

class KeyboardTest extends \PHPUnit\Framework\TestCase
{

    public function test_the_result(): void
    {
        $raw_data = $this->create_a_inline_keyboard();

        $this->assertEquals(true, $raw_data['one_time_keyboard']);
        $this->assertEquals(true, $raw_data['selective']);

        $keyboard = json_encode([
            [
                ['text' => 'Button 1', 'web_app' => ['url' => 'https://google.com']],
                ['text' => 'Button 2', 'url' => 'https://google.com'],
            ],
            [
                ['text' => 'Button 3', 'callback_data' => 'callback_data'],
                ['text' => 'Button 4', 'callback_data' => 'callback_data'],
            ],
        ]);

        $this->assertEquals($keyboard, json_encode($raw_data['inline_keyboard']));
    }

    public function create_a_inline_keyboard(): array
    {
        return InlineKeyboard::make()
            ->setOneTimeKeyboard(true)
            ->setSelective(true)
            ->setKeyboard([
                [
                    InlineKeyboardButton::make('Button 1')->setWebApp('https://google.com'),
                    InlineKeyboardButton::make('Button 2')->setUrl('https://google.com'),
                ],
                [
                    InlineKeyboardButton::make('Button 3')->setCallbackData('callback_data'),
                    InlineKeyboardButton::make('Button 4')->setCallbackData('callback_data'),
                ],
            ]);
    }

    public function test_send_message_with_keyboard(): void
    {
        $raw_data = $this->create_a_keyboard();

        $result = Request::create('sendMessage', [
            'chat_id' => 'chat_id',
            'text' => 'text',
            'parse_mode' => 'Markdown',
            'reply_markup' => $raw_data,
        ]);

        $keyboard = json_decode($result['options']['query']['reply_markup'], true);

        $this->assertEquals(true, $keyboard['resize_keyboard']);

        $this->assertEquals(true, $keyboard['one_time_keyboard']);

        $this->assertEquals(true, $keyboard['selective']);

        $compare_with = json_encode([
            [
                ['text' => 'Button 1', 'web_app' => ['url' => 'https://google.com']],
                ['text' => 'Button 2'],
            ],
            [
                ['text' => 'Button 3'],
                ['text' => 'Button 4'],
            ],
        ]);

        $this->assertEquals($compare_with, json_encode($keyboard['keyboard']));
    }

    public function create_a_keyboard(): array
    {
        return Keyboard::make()
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(true)
            ->setKeyboard([
                [
                    KeyboardButton::make('Button 1')->setWebApp('https://google.com'),
                    KeyboardButton::make('Button 2'),
                ],
                [
                    KeyboardButton::make('Button 3'),
                    KeyboardButton::make('Button 4'),
                ],
            ]);
    }

    public function test_create_for_answer_query(): void
    {
        $raw_data = $this->create_a_inline_keyboard();
        $result = Request::create('answerCallbackQuery', [
            'callback_query_id' => 'callback_query_id',
            'text' => 'text',
            'show_alert' => true,
            'url' => 'https://google.com',
            'cache_time' => 10,
            'reply_markup' => $raw_data,
        ]);

        $this->assertEquals(true, $result['options']['query']['show_alert']);
        $this->assertEquals('https://google.com', $result['options']['query']['url']);
        $this->assertEquals(10, $result['options']['query']['cache_time']);
        $this->assertEquals(json_encode($raw_data), $result['options']['query']['reply_markup']);
    }

}