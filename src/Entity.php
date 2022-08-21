<?php

namespace TelegramBot;

/**
 * Entity class
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
    protected array $raw_data = [];

    /**
     * Entity constructor.
     *
     * @param ?array $data The raw data passed to this entity
     */
    public function __construct(?array $data)
    {
        if (!empty($data)) {
            $this->assignMemberVariables(($this->raw_data = $data));
            $this->validate();
        }
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
     * Perform any special entity validation
     *
     * @return void
     */
    protected function validate(): void
    {
        // Do nothing by default
    }

    /**
     * Escape markdown (v1) special characters
     *
     * @see https://core.telegram.org/bots/api#markdown-style
     *
     * @param string $string
     *
     * @return string
     */
    public static function escapeMarkdown(string $string): string
    {
        return str_replace(
            ['[', '`', '*', '_',],
            ['\[', '\`', '\*', '\_',],
            $string
        );
    }

    /**
     * Escape markdown (v2) special characters
     *
     * @see https://core.telegram.org/bots/api#markdownv2-style
     *
     * @param string $string
     *
     * @return string
     */
    public static function escapeMarkdownV2(string $string): string
    {
        return str_replace(
            ['_', '*', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'],
            ['\_', '\*', '\[', '\]', '\(', '\)', '\~', '\`', '\>', '\#', '\+', '\-', '\=', '\|', '\{', '\}', '\.', '\!'],
            $string
        );
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
     * @param string $name The name of the property
     * @param array $arguments The arguments passed to the method
     * @return mixed
     */
    public function __call(string $name, array $arguments): mixed
    {
        if (method_exists($this, $name)) {
            return $this->{$name}(...$arguments);
        }

        if (str_starts_with($name, 'get')) {
            $property_name = strtolower(ltrim(preg_replace('/[A-Z]/', '_$0', substr($name, 3)), '_'));

            $property = $this->getProperty($property_name);
            $sub_entities = $this->subEntities() ?? [];

            if (isset($sub_entities[$property_name])) {
                $class_name = $sub_entities[$property_name];
                return Factory::resolveEntityClass($class_name, $property);
            }

            return $property ?? null;
        }

        if (str_starts_with($name, 'set')) {
            $property_name = strtolower(ltrim(preg_replace('/[A-Z]/', '_$0', substr($name, 3)), '_'));
            $this->raw_data[$property_name] = $arguments[0];

            if (property_exists($this, $property_name)) {
                $this->{$property_name} = $arguments[0];
            }

            return $this;
        }

        throw new \BadMethodCallException("Method {$name} does not exist");
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

}