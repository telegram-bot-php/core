<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;

/**
 * Class Plugin
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
abstract class Plugin
{

	/**
	 * The Update types
	 *
	 * @var array
	 */
	protected array $update_types = [
		'message',
		'edited_message',
		'channel_post',
		'edited_channel_post',
		'inline_query',
		'chosen_inline_result',
		'callback_query',
		'shipping_query',
		'pre_checkout_query',
	];

	/**
	 * @var WebhookHandler
	 */
	protected WebhookHandler $hook;

	/**
	 * @var \Generator
	 */
	protected \Generator $returns;

	/**
	 * @var bool
	 */
	protected bool $kill_on_yield = false;

	/**
	 * Check for the exit of the plugin.
	 *
	 * @param \Generator $return
	 * @return void
	 */
	public function __checkExit(\Generator $return): void
	{
		if ($return->valid()) {
			if ($return->current() !== null && $this->kill_on_yield === true) {
				$this->kill();
			}
		}

		if ($return->valid()) {
			$return->next();
			$this->__checkExit($return);
		}
	}

	/**
	 * Identify the update type. e.g. Message, EditedMessage, etc.
	 *
	 * @param Update $update
	 * @return string|null
	 */
	public function __identify(Update $update): ?string
	{
		$type = $update->getUpdateType();

		if ($type === null) {
			return null;
		}

		return str_replace('_', '', ucwords($type, '_'));
	}


	/**
	 * Execute the plugin.
	 *
	 * @param WebhookHandler $receiver
	 * @param Update $update
	 * @return void
	 */
	public function __execute(WebhookHandler $receiver, Update $update): void
	{
		$this->hook = $receiver;

		if (method_exists($this, 'onReceivedUpdate')) {
			$return = $this->onReceivedUpdate($update);
			$this->__checkExit($return);
		}

		$type = $this->__identify($update);
		if (method_exists($this, ($method = 'on' . $type)) && $type !== null) {
			$return = $this->$method($update);
			$this->__checkExit($return);
		}
	}

	/**
	 * Identify the update type and if method of the type is exists, execute it.
	 *
	 * @param Update $update
	 * @return \Generator
	 */
	abstract protected function onReceivedUpdate(Update $update): \Generator;

	/**
	 * Kill the plugin.
	 *
	 * @return void
	 */
	public function kill(): void
	{
		$this->hook->kill();
	}

}