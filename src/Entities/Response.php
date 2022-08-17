<?php

namespace TelegramBot\Entities;

use TelegramBot\Entity;

/**
 * Class Response
 *
 * @link https://core.telegram.org/bots/api#making-requests
 *
 * @method bool   getOk()           If the request was successful
 * @method mixed  getResult()       The result of the query
 * @method int    getErrorCode()    Error code of the unsuccessful request
 * @method string getDescription()  Human-readable description of the result / unsuccessful request
 */
class Response extends Entity
{

    /**
     * @var array
     */
    protected array $requiredFields = [
        'ok',
        'result',
    ];

    /**
     * The raw response from Telegram Bot API.
     *
     * @var array
     */
    protected array $response;

    /**
     * Server Response constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $data['raw_data'] = $data;
        $this->response = $data;

        $is_ok = (bool)($data['ok'] ?? false);
        $result = $data['result'] ?? null;

        if ($is_ok) {
            foreach ($this->requiredFields as $field) {
                if (!isset($data[$field])) {
                    throw new \InvalidArgumentException("The field '{$field}' is required.");
                }
            }
        }

        parent::__construct($data);
    }

    /**
     * If response is ok
     *
     * @return bool
     */
    public function isOk(): bool
    {
        return $this->getOk();
    }

    /**
     * Print error
     *
     * @see https://secure.php.net/manual/en/function.print-r.php
     *
     * @param bool $return
     * @return bool|string
     */
    public function printError(bool $return = false): bool|string
    {
        $error = sprintf('Error N: %s, Description: %s', $this->getErrorCode(), $this->getDescription());

        if ($return) {
            return $error;
        }

        echo $error;

        return true;
    }

    /**
     * Check if array is associative
     *
     * @param array $array
     * @return bool
     */
    protected function isAssoc(array $array): bool
    {
        return count(array_filter(array_keys($array), 'is_string')) > 0;
    }

}
