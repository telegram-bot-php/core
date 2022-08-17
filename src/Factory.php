<?php

namespace TelegramBot;

/**
 * Factory class
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
abstract class Factory
{

    /**
     * This method is used to create a new instance of the entity.
     *
     * @param string $class
     * @param mixed $property
     * @return Entity
     */
    public static function resolveEntityClass(string $class, mixed $property): Entity
    {
        if (is_subclass_of($class, Factory::class)) {
            return $class::make($property);
        }

        return new $class($property);
    }

    /**
     * @param array $data
     * @return Entity
     */
    abstract public static function make(array $data): Entity;

}
