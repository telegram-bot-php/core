<?php

namespace TelegramBot\Exception;

/**
 * Thrown when bot token is invalid
 */
class InvalidBotTokenException extends TelegramException
{

    /**
     * InvalidBotTokenException constructor
     */
    public function __construct()
    {
        parent::__construct('Invalid bot token!');
    }

}
