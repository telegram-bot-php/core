<?php


namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class Keyboard
 *
 * @link https://core.telegram.org/bots/api#replykeyboardmarkup
 *
 * @method bool   getResizeKeyboard()           Optional. Requests clients to resize the keyboard vertically for optimal fit (e.g., make the keyboard smaller if there are just two rows of buttons). Defaults to false, in which case the custom keyboard is always of the same height as the app's standard keyboard.
 * @method bool   getOneTimeKeyboard()          Optional. Requests clients to remove the keyboard as soon as it's been used. The keyboard will still be available, but clients will automatically display the usual letter-keyboard in the chat – the user can press a special button in the input field to see the custom keyboard again. Defaults to false.
 * @method string getInputFieldPlaceholder()    Optional. The placeholder to be shown in the input field when the keyboard is active;
 * @method bool   getSelective()                Optional. Use this parameter if you want to show the keyboard to specific users only. Targets: 1) users that are @mentioned in the text of the Message object;
 *
 * @method $this setResizeKeyboard(bool $resize_keyboard)                    Optional. Requests clients to resize the keyboard vertically for optimal fit (e.g., make the keyboard smaller if there are just two rows of buttons). Defaults to false, in which case the custom keyboard is always of the same height as the app's standard keyboard.
 * @method $this setOneTimeKeyboard(bool $one_time_keyboard)                 Optional. Requests clients to remove the keyboard as soon as it's been used. The keyboard will still be available, but clients will automatically display the usual letter-keyboard in the chat – the user can press a special button in the input field to see the custom keyboard again. Defaults to false.
 * @method $this setInputFieldPlaceholder(string $input_field_placeholder)   Optional. The placeholder to be shown in the input field when the keyboard is active;
 * @method $this setSelective(bool $selective)                               Optional. Use this parameter if you want to show the keyboard to specific users only. Targets: 1) users that are @mentioned in the text of the Message object;
 */
class Keyboard extends Entity
{

    /**
     * Remove the current custom keyboard and display the default letter-keyboard.
     *
     * @link https://core.telegram.org/bots/api/#replykeyboardremove
     *
     * @param array $data
     *
     * @return Keyboard
     */
    public static function remove(array $data = []): Keyboard
    {
        return new static(array_merge(['keyboard' => [], 'remove_keyboard' => true, 'selective' => false], $data));
    }

    /**
     * Display a reply interface to the user (act as if the user has selected the bot's message and tapped 'Reply').
     *
     * @link https://core.telegram.org/bots/api#forcereply
     *
     * @param array $data
     *
     * @return Keyboard
     */
    public static function forceReply(array $data = []): Keyboard
    {
        return new static(array_merge(['keyboard' => [], 'force_reply' => true, 'selective' => false], $data));
    }

    /**
     * Creates instance of Keyboard
     *
     * @return Keyboard
     */
    public static function make(): Keyboard
    {
        return new self([]);
    }

    /**
     * @param array $rows
     * @return array
     */
    public function setKeyboard(array $rows): array
    {
        foreach ($rows as $row) {
            $this->addRow($row);
        }

        return $this->getRawData();
    }

    /**
     * Create a new row in keyboard and add buttons.
     *
     * @param array<KeyboardButton> $row
     * @return Keyboard
     */
    public function addRow(array $row): Keyboard
    {
        $keyboard_type = self::getType();

        if (!isset($this->raw_data[$keyboard_type]) || !is_array($this->raw_data[$keyboard_type])) {
            $this->raw_data[$keyboard_type] = [];
        }

        $new_row = [];
        foreach ($row as $button) {
            $new_row[] = $button->getRawData();
        }

        $this->raw_data[$keyboard_type][] = $new_row;

        return $this;
    }

    /**
     * Get keyboard button type
     *
     * @return string ["keyboard"|"inline_keyboard"]
     */
    public function getType(): string
    {
        $reflection = new \ReflectionClass(static::class);

        $class_name = $reflection->getShortName();

        return strtolower(ltrim(preg_replace('/[A-Z]/', '_$0', $class_name), '_'));
    }

}
