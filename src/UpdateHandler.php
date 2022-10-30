<?php

namespace TelegramBot;

use TelegramBot\Entities\Update;
use TelegramBot\Exception\InvalidBotTokenException;
use TelegramBot\Interfaces\HandlerInterface;
use TelegramBot\Traits\HandlerTrait;
use TelegramBot\Util\Toolkit;

/**
 * UpdateHandler class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class UpdateHandler extends Telegram implements HandlerInterface {

   use HandlerTrait;

   /**
    * @var ?Update
    */
   protected ?Update $update;

   /**
    * @var Plugin[]
    */
   private array $plugins = [];

   /**
    * @var bool
    */
   private bool $active_spreader = false;

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
    * Filter incoming updates.
    *
    * @var array
    */
   private array $filterIncomingUpdates = [];

   /**
    * Webhook constructor.
    *
    * @param string $api_token The API key of the bot. Leave it blank for autoload from .env file.
    */
   public function __construct(string $api_token = '') {
      parent::__construct($api_token);

      if (!Telegram::validateToken(self::getApiToken())) {
         throw new InvalidBotTokenException();
      }
   }

   /**
    * Resolve the request on single plugin.
    *
    * @param Plugin $plugin The plugin to work with
    * @param ?Update $update The custom to work with
    * @param array $config The configuration of the receiver
    * @return void
    */
   public static function resolveOn(Plugin $plugin, Update $update = null, array $config = []): void {
      // TODO: Implement resolveOn() method.
   }

   /**
    * Add plugins to the receiver
    *
    * @param Plugin[]|array $plugins
    * @retrun void
    */
   public function addPlugins(Plugin|array $plugins): UpdateHandler {
      if (is_object($plugins)) {
         $plugins = [$plugins];
      }

      foreach ($plugins as $plugin) {
         if (!is_subclass_of($plugin, Plugin::class)) {
            throw new \RuntimeException(
               sprintf('The plugin %s must be an instance of %s', get_class($plugin), Plugin::class)
            );
         }

         $reflection = Toolkit::reflectionClass($plugin);
         $this->plugins[] = [
            'class' => $plugin,
            'initialized' => is_object($plugin),
         ];
      }

      return $this;
   }

   /**
    * Updates the filter for incoming updates.
    *
    * @param array $filter
    * @return void
    */
   public function filterIncomingUpdates(array $filter): void {
      $this->filterIncomingUpdates = $filter;
   }

   /**
    * Do not process updates that match the filter.
    *
    * @param Update $update
    * @return bool
    */
   private function isFiltered(Update $update): bool {
      if (empty($this->filterIncomingUpdates)) {
         return false;
      }

      foreach ($this->filterIncomingUpdates as $type => $value) {
         if (is_int($type)) {
            if ($update->getUpdateType() === $value) {
               return true;
            }
         } elseif (is_string($type)) {
            if ($update->getUpdateType() === $type) {
               if (is_callable($value)) {
                  return $value($update);
               } elseif (is_bool($value)) {
                  return $value;
               }
               throw new \InvalidArgumentException('The value of the filter must be a callable or a boolean');
            }
         }
         throw new \InvalidArgumentException('Invalid filter');
      }

      return false;
   }

   /**
    * Resolve the request.
    *
    * @param ?Update $update The custom to work with
    * @param array $config The configuration of the receiver
    *
    * @retrun void
    */
   public function resolve(Update|null $update = null, array $config = []): void {
      $this->update = $update ?? Telegram::getUpdate();

      if (empty($this->update)) {
         TelegramLog::error('The update is empty, the request is not processed');
         return;
      }

      if ($this->isFiltered($this->update)) {
         TelegramLog::notice('The update is filtered, the request is not processed');
         return;
      }

      if (!method_exists($this, '__process')) {
         throw new \RuntimeException('The method __process does not exist');
      }

      if (is_array($config)) {
         $this->updateConfiguration($config);
      }

      putenv('TG_CURRENT_UPDATE=' . $this->update->getRawData(false));

      $this->__process($this->update);
      $this->loadPlugins($this->plugins);
   }

   /**
    * Update the configuration
    *
    * @param array $configuration
    * @return void
    */
   public function updateConfiguration(array $configuration): void {
      $this->config = array_merge($this->config, $configuration);
   }

   /**
    * Match the update with the given plugins
    *
    * @param Plugin[]|array $plugins
    * @return void
    */
   private function loadPlugins(array $plugins): void {
      $update = $update ?? ($this->update ?? Telegram::getUpdate());

      foreach ($plugins as $plugin) {
         if (!is_subclass_of($plugin['class'], Plugin::class)) {
            throw new \InvalidArgumentException(sprintf(
               'The plugin %s must be an instance of %s',
               get_class($plugin['class']), Plugin::class
            ));
         }
      }

      if (!$update instanceof Update) {
         throw new \InvalidArgumentException(sprintf(
            'The update must be an instance of %s. %s given',
            Update::class, gettype($update)
         ));
      }

      $this->spreadUpdateWith($update, $plugins);
   }

   /**
    * This function will get update and spread it to the plugins
    *
    * @param Update $update
    * @param array<Plugin> $plugins
    * @return void
    */
   private function spreadUpdateWith(Update $update, array $plugins): void {
      $this->active_spreader = true;

      foreach ($plugins as $plugin) {
         if ($plugin['initialized'] === false) {
            $plugin['class'] = new $plugin['class']();
         }

         $plugin['class']->__execute($this, $update);
         if ($this->active_spreader === false) break;
      }

      $this->active_spreader = false;
   }

   /**
    * Stop the spreader process
    *
    * @return void
    */
   public function stop(): void {
      $this->active_spreader = false;
   }

}