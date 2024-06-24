<?php declare(strict_types=1);

namespace TelegramBotTest;

use Faker\Factory;
use Faker\Generator;
use TelegramBot\Entities\Message;

class DummyUpdate {


    private static function faker(): Generator {
        return Factory::create();
    }

    public static function message(): Message {
        return new Message([
            'message_id' => self::faker()->randomNumber(),
            'from' => [
                'id' => self::faker()->randomNumber(),
                'is_bot' => false,
                'first_name' => self::faker()->firstName(),
                'last_name' => self::faker()->lastName(),
                'username' => self::faker()->userName(),
                'language_code' => self::faker()->languageCode(),
            ],
            'chat' => [
                'id' => self::faker()->randomNumber(),
                'first_name' => self::faker()->firstName(),
                'last_name' => self::faker()->lastName(),
                'username' => self::faker()->userName(),
                'type' => 'private',
            ],
            'date' => self::faker()->unixTime(),
            'text' => self::faker()->sentence(),
        ]);
    }

    public static function messageWithEntities(): Message {
        return new Message([
            'message_id' => self::faker()->randomNumber(),
            'from' => [
                'id' => self::faker()->randomNumber(),
                'is_bot' => false,
                'first_name' => self::faker()->firstName(),
                'last_name' => self::faker()->lastName(),
                'username' => self::faker()->userName(),
                'language_code' => self::faker()->languageCode(),
            ],
            'chat' => [
                'id' => self::faker()->randomNumber(),
                'first_name' => self::faker()->firstName(),
                'last_name' => self::faker()->lastName(),
                'username' => self::faker()->userName(),
                'type' => 'private',
            ],
            'date' => self::faker()->unixTime(),
            'text' => self::faker()->sentence(),
            'entities' => [
                [
                    'offset' => 0,
                    'length' => 1,
                    'type' => 'bold',
                ],
                [
                    'offset' => 2,
                    'length' => 3,
                    'type' => 'italic',
                ],
                [
                    'offset' => 6,
                    'length' => 7,
                    'type' => 'code',
                ]
            ]
        ]);
    }

    public static function messageWithReply(): Message {
        return new Message([
            'message_id' => self::faker()->randomNumber(),
            'from' => [
                'id' => self::faker()->randomNumber(),
                'is_bot' => false,
                'first_name' => self::faker()->firstName(),
                'last_name' => self::faker()->lastName(),
                'username' => self::faker()->userName(),
                'language_code' => self::faker()->languageCode(),
            ],
            'chat' => [
                'id' => self::faker()->randomNumber(),
                'first_name' => self::faker()->firstName(),
                'last_name' => self::faker()->lastName(),
                'username' => self::faker()->userName(),
                'type' => 'private',
            ],
            'date' => self::faker()->unixTime(),
            'text' => self::faker()->sentence(),
            'reply_to_message' => [
                'message_id' => self::faker()->randomNumber(),
                'from' => [
                    'id' => self::faker()->randomNumber(),
                    'is_bot' => false,
                    'first_name' => self::faker()->firstName(),
                    'last_name' => self::faker()->lastName(),
                    'username' => self::faker()->userName(),
                    'language_code' => self::faker()->languageCode(),
                ],
                'chat' => [
                    'id' => self::faker()->randomNumber(),
                    'first_name' => self::faker()->firstName(),
                    'last_name' => self::faker()->lastName(),
                    'username' => self::faker()->userName(),
                    'type' => 'private',
                ],
                'date' => self::faker()->unixTime(),
                'text' => self::faker()->sentence(),
            ]
        ]);
    }

}
