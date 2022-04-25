<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;
use TelegramBot\Util\DotEnv;

/**
 * Class Receiver
 *
 * @link    https://github.com/shahradelahi/telegram-bot
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/telegram-bot/blob/master/LICENSE (MIT License)
 */
abstract class Receiver
{

    /**
     * The default configuration of the receiver.
     *
     * @var array
     */
    private array $config = [
        'autoload_environment' => true,
        'environment_file' => null,
    ];

    /**
     * @var array<Plugin>
     */
    private array $plugins = [];

    /**
     * @var Update
     */
    private Update $update;

    /**
     * @var Telegram
     */
    private Telegram $telegram;

    /**
     * @var bool
     */
    private bool $isActive = false;

    /**
     * Get token from env file.
     *
     * @param string $file
     * @return ?string
     */
    private function getTokenFromEnvFile(string $file): ?string
    {
        if (!file_exists($file)) return null;
        return DotEnv::loadFrom($file)::get('TELEGRAM_API_KEY');
    }

    /**
     * Receiver constructor.
     *
     * @param string|array $input
     * @throws \Exception
     */
    public function __construct(string|array $input = '')
    {
        $api_key = '';

        $this->init();
        if (is_array($input)) {
            $this->config = array_merge($this->config, $input);
        } else {
            if (Telegram::validateToken($input)) {
                $api_key = $input;
            } elseif ($input !== '') {
                if (!$this->getTokenFromEnvFile($input)) {
                    throw new \Exception('Invalid token or file path.');
                }
                $api_key = $this->getTokenFromEnvFile($input);
            }
        }

        if ($this->config['autoload_environment']) {
            $api_key = $this->getTokenFromEnvFile($this->config['environment_file']);
        }

        if (!Telegram::validateToken($api_key)) {
            throw new \Exception('The API key is invalid.');
        }

        $this->telegram = new Telegram($api_key);
    }

    /**
     * Initialize the receiver.
     *
     * @return void
     */
    public function init(): void
    {
        $this->config['environment_file'] = $_SERVER['DOCUMENT_ROOT'] . '/.env';
    }

    /**
     * Add a plugin to the receiver
     *
     * @param array<Plugin> $plugins
     */
    public function addPlugin(array $plugins): void
    {
        foreach ($plugins as $plugin) {
            if (!$plugin instanceof Plugin) {
                throw new \InvalidArgumentException('Plugin must be an instance of \TelegramBot\Plugin');
            }
            $this->plugins[] = $plugin;
        }
    }

    /**
     * Match the message to the plugins
     *
     * @return void
     */
    public function match(): void
    {
        foreach ($this->plugins as $plugin) {
            $plugin->__run($this->update);
        }
    }

    /**
     * Load the environment's
     *
     * @param string $path
     * @retrun void
     */
    public function loadEnvironment(string $path): void
    {
        $dotEnv = new \TelegramBot\Util\DotEnv();
        $dotEnv->loadFrom($path);
    }

    /**
     * Resolve the request.
     *
     * @param array $config
     * @param ?Update $update
     *
     * @retrun void
     */
    public function resolve(array $config = [], Update $update = null): void
    {
        $method = '__process';
        if (!method_exists($this, $method)) {
            throw new \RuntimeException('The __process(Update $update) method has not implemented');
        }

        if (is_array($config)) $this->updateConfiguration($config);

        $this->update = $update->isOk() ? $update : $this->telegram->processUpdate(Telegram::getInput());

        $this->isActive = true;

        foreach ($this->plugins as $plugin) {
            (new $plugin($this->telegram))->__execute($this->update);
            /**
             * The isActive property can be set to false by the plugin
             *
             * @noinspection PhpConditionAlreadyCheckedInspection
             */
            if ($this->isActive === false) break;
        }

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
     * Kill the process
     *
     * @return void
     */
    public function kill(): void
    {
        $this->isActive = false;
    }

}