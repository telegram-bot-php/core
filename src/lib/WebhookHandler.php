<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;
use TelegramBot\Util\DotEnv;

/**
 * Class Webhook
 *
 * @link    https://github.com/shahradelahi/telegram-bot
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/telegram-bot/blob/master/LICENSE (MIT License)
 */
abstract class WebhookHandler
{

    /**
     * @var array<Plugin>
     */
    private array $plugins = [];

    /**
     * @var Telegram
     */
    private Telegram $telegram;

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
        'autoload_env_file' => true,
        'env_file_path' => null, // Default: $_SERVER['DOCUMENT_ROOT'] . '/.env'
    ];

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
     * Webhook constructor.
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

        if ($this->config['autoload_env_file']) {
            $api_key = $this->getTokenFromEnvFile($this->config['env_file_path']);
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
            if (!$plugin instanceof Plugin) {
                throw new \InvalidArgumentException('Plugin must be an instance of \TelegramBot\Plugin');
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
        $update = $update ?? Telegram::getUpdate();
        foreach ($plugins as $plugin) {
            if (!is_subclass_of($plugin, Plugin::class)) {
                throw new \InvalidArgumentException('Plugin must be an instance of \TelegramBot\Plugin');
            }
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
        $this->loadPluginsWith($this->plugins, $update ?? Telegram::getUpdate());
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

        $update = $update->isOk() ? $update : $this->telegram->processUpdate(Telegram::getInput());
        $this->spreadUpdateWith($update, $this->plugins);
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
            (new $plugin($this->telegram))->__execute($this, $update);
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

}