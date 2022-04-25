<?php

namespace TelegramBot;

/**
 * Class Factory
 *
 * @link    https://github.com/shahradelahi/telegram-bot
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/shahradelahi/telegram-bot/blob/master/LICENSE (MIT License)
 */
abstract class Factory
{

    /**
     * @param array $data
     * @return Entity
     */
    abstract public static function make(array $data): Entity;

    /**
     * This method is used to create a new instance of the entity.
     *
     * @param string $class
     * @param array $property
     * @return Entity
     */
    public static function resolveEntityClass(string $class, array $property): Entity
    {
        if (is_subclass_of($class, Factory::class)) {
            return $class::make($property);
        }

        return new $class($property);
    }

}
