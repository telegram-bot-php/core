<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use TelegramBot\Entities\InlineKeyboard;
use TelegramBot\Entities\InlineKeyboardButton;
use TelegramBot\Entities\Keyboard;
use TelegramBot\Entities\KeyboardButton;
use TelegramBot\Request;

class KeyboardTest extends TestCase
{

	public function create_a_inline_keyboard(): InlineKeyboard
	{
		return InlineKeyboard::make()
			->setOneTimeKeyboard(true)
			->setSelective(true)
			->setKeyboard([
				[
					InlineKeyboardButton::make('Button 1')->WebApp('https://google.com'),
					InlineKeyboardButton::make('Button 2')->Url('https://google.com'),
				],
				[
					InlineKeyboardButton::make('Button 3')->CallbackData('callback_data'),
					InlineKeyboardButton::make('Button 4')->CallbackData('callback_data'),
				],
			]);
	}

	public function test_the_result(): void
	{
		$raw_data = $this->create_a_inline_keyboard()->getRawData();

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

	public function create_a_keyboard(): Keyboard
	{
		return Keyboard::make()
			->setResizeKeyboard(true)
			->setOneTimeKeyboard(true)
			->setSelective(true)
			->setKeyboard([
				[
					KeyboardButton::make('Button 1')->WebApp('https://google.com'),
					KeyboardButton::make('Button 2'),
				],
				[
					KeyboardButton::make('Button 3'),
					KeyboardButton::make('Button 4'),
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

}