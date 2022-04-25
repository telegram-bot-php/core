<?php

namespace TelegramBot;

/**
 * Class Entity
 *
 * This is the base class for all entities.
 *
 * @link https://core.telegram.org/bots/api#available-types
 */
abstract class Entity
{

    /**
     * @var array The raw data passed to this entity
     */
    protected array $raw_data;

    /**
     * Entity constructor.
     *
     * @param array $data The raw data passed to this entity
     */
    public function __construct(array $data)
    {
        $this->assignMemberVariables(($this->raw_data = $data));
        $this->validate();
    }

    /**
     * Get the raw data passed to this entity
     *
     * @param bool $associated
     * @return array|string
     */
    public function getRawData(bool $associated = true): array|string
    {
        return $associated ? $this->raw_data : json_encode($this->raw_data);
    }

    /**
     * Helper to set member variables
     *
     * @param array $data
     * @return void
     */
    protected function assignMemberVariables(array $data): void
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    /**
     * Get a property from the current Entity
     *
     * @param string $property
     * @param mixed $default
     *
     * @return mixed
     */
    public function getProperty(string $property, mixed $default = null): mixed
    {
        return $this->raw_data[$property] ?? $default;
    }

    /**
     * Get the list of the properties that are themselves Entities
     *
     * @return array
     */
    protected function subEntities(): array
    {
        return [];
    }


    /**
     * Perform any special entity validation
     *
     * @return void
     */
    protected function validate(): void
    {
        // Do nothing by default
    }

    /**
     * @param string $name The name of the property
     * @param array $arguments The arguments passed to the method
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this, $name)) {
            return $this->{$name}();
        }

        if (str_starts_with($name, 'get')) {
            $property_name = mb_strtolower(ltrim(preg_replace('/[A-Z]/', '_$0', substr($name, 3)), '_'));

            $property = $this->getProperty($property_name);
            $sub_entities = $this->subEntities() ?? [];

            if (property_exists($this, $property_name)) {
                return $this->{$property_name};
            }

            if (isset($sub_entities[$property_name])) {
                $class_name = $sub_entities[$property_name];
                return Factory::resolveEntityClass($class_name, $property);
            }

            return $property;
        }

        if (str_starts_with($name, 'set')) {
            $property_name = mb_strtolower(ltrim(preg_replace('/[A-Z]/', '_$0', substr($name, 3)), '_'));

            if (property_exists($this, $property_name)) {
                $this->{$property_name} = $arguments[0];

                return $this;
            }

        }

        throw new \BadMethodCallException("Method $name does not exist");
    }

}