<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;
use TelegramBot\Exception\InvalidBotTokenException;
use TelegramBot\Util\CrossData;
use TelegramBot\Util\DotEnv;

/**
 * Class Webhook
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
abstract class WebhookHandler extends Telegram
{

	/**
	 * @var ?Update
	 */
	protected ?Update $update;

	/**
	 * @var array<Plugin>
	 */
	private array $plugins = [];

	/**
	 * @var bool
	 */
	private bool $isActive = false;

	/**
	 * The default configuration of the webhook.
	 *
	 * @var array
	 */
	private array $config = [
		'autoload_env_file' => false,
		'env_file_path' => null,
	];

	/**
	 * Webhook constructor.
	 *
	 * @param string $api_key The API key of the bot. Leave it blank for autoload from .env file.
	 */
	public function __construct(string $api_key = '')
	{
		parent::__construct($api_key);

		if (!Telegram::validateToken(self::getApiKey())) {
			throw new InvalidBotTokenException();
		}
	}

	/**
	 * Initialize the receiver.
	 *
	 * @return void
	 */
	public function init(): void
	{
		$this->config['env_file_path'] = $_SERVER['DOCUMENT_ROOT'] . '/.env';
	}

	/**
	 * Add a plugin to the receiver
	 *
	 * @param array<Plugin> $plugins
	 */
	public function addPlugin(array $plugins): void
	{
		foreach ($plugins as $plugin) {
			if (!is_subclass_of($plugin, Plugin::class)) {
				throw new \RuntimeException(
					sprintf('The plugin %s must be an instance of %s', get_class($plugin), Plugin::class)
				);
			}
			$this->plugins[] = $plugin;
		}
	}

	/**
	 * Match the update with the given plugins
	 *
	 * @param array<Plugin> $plugins
	 * @param ?Update $update The update to match
	 * @return void
	 */
	public function loadPluginsWith(array $plugins, Update $update = null): void
	{
		$update = $update ?? ($this->update ?? Telegram::getUpdate());

		foreach ($plugins as $plugin) {
			if (!is_subclass_of($plugin, Plugin::class)) {
				throw new \InvalidArgumentException(
					sprintf('The plugin %s must be an instance of %s', get_class($plugin), Plugin::class)
				);
			}
		}

		if ($update instanceof Update) {
			$this->spreadUpdateWith($update, $plugins);
		}
	}

	/**
	 * Match the message to the plugins
	 *
	 * @param ?Update $update The update to match
	 * @return void
	 */
	public function loadPlugins(Update $update = null): void
	{
		$update = $update ?? ($this->update ?? Telegram::getUpdate());
		$this->loadPluginsWith($this->plugins, $update);
	}

	/**
	 * Load the environment's
	 *
	 * @param string $path
	 * @retrun void
	 */
	public function loadFileOfEnv(string $path): void
	{
		DotEnv::load($path);
	}

	/**
	 * Update the configuration
	 *
	 * @param array $configuration
	 * @return void
	 */
	public function updateConfiguration(array $configuration): void
	{
		$this->config = array_merge($this->config, $configuration);
	}

	/**
	 * Resolve the request.
	 *
	 * @param ?Update $update The custom to work with
	 * @param array $config The configuration of the receiver
	 *
	 * @retrun void
	 */
	public function resolve(Update $update = null, array $config = []): void
	{
		$method = '__process';
		if (!method_exists($this, $method)) {
			throw new \RuntimeException(sprintf('The method %s does not exist', $method));
		}

		if (is_array($config)) $this->updateConfiguration($config);

		if (!empty($update)) $this->update = $update;
		else $this->update = Telegram::getUpdate() !== false ? Telegram::getUpdate() : null;

		if (empty($this->update)) {
			TelegramLog::error(
				'The update is empty, the request is not processed'
			);
			return;
		}

		putenv('TG_CURRENT_UPDATE=' . $this->update->getRawData(false));

		$this->$method($this->update);
	}

	/**
	 * This function will get update and spread it to the plugins
	 *
	 * @param Update $update
	 * @param array<Plugin> $plugins
	 * @return void
	 */
	private function spreadUpdateWith(Update $update, array $plugins): void
	{
		$this->isActive = true;

		foreach ($plugins as $plugin) {
			/** @var Plugin $plugin */
			(new $plugin())->__execute($this, $update);
			if ($this->isActive === false) break;
		}

		$this->isActive = false;
	}

	/**
	 * Kill the speeding process
	 *
	 * @return void
	 */
	public function kill(): void
	{
		$this->isActive = false;
	}

	/**
	 * Use this method on the webhook class to get the updates
	 *
	 * @param Update $update
	 * @return void
	 */
	abstract public function __process(Update $update): void;

	/**
	 * put CrossData into the plugins
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function putCrossData(string $key, mixed $value): void
	{
		CrossData::put($key, $value);
	}

	/**
	 * get CrossData from the plugins
	 *
	 * @param string $key
	 * @return string|array|bool|null
	 */
	public function getCrossData(string $key): string|array|bool|null
	{
		return CrossData::get($key);
	}

}