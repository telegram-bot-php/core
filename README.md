<p align="center">
<img src="logo.png" alt="logo" width="250" height="250"/>
</p>
<p align="center">
  <a href="https://github.com/telegram-bot-php/core/actions"><img src="https://github.com/telegram-bot-php/core/workflows/PHPUnit%20Test/badge.svg" alt="Build Status" /></a>
  <a href="https://scrutinizer-ci.com/g/telegram-bot-php/core/?branch=master"><img src="https://img.shields.io/scrutinizer/g/telegram-bot-php/core/master.svg?style=flat" alt="Code Quality" /></a>
  <a href="https://scrutinizer-ci.com/g/telegram-bot-php/core/?branch=master"><img src="https://scrutinizer-ci.com/g/telegram-bot-php/core/badges/code-intelligence.svg?b=master" alt="Code Intelligence Status" /></a>
  <a href="https://scrutinizer-ci.com/g/telegram-bot-php/core/?branch=master"><img src="https://scrutinizer-ci.com/g/telegram-bot-php/core/badges/coverage.png?b=master" alt="Code Coverage" /></a>
</p>
<p align="center">
  <a href="https://packagist.org/packages/telegram-bot-php/core"><img src="https://img.shields.io/packagist/v/telegram-bot-php/core.svg?cacheSeconds=3600" alt="Latest Stable Version" /></a>
  <a href="https://packagist.org/packages/telegram-bot-php/core"><img src="https://img.shields.io/github/languages/code-size/telegram-bot-php/core?cacheSeconds=3600" alt="Code Size" /></a>
  <a href="https://packagist.org/packages/telegram-bot-php/core"><img src="https://img.shields.io/packagist/dt/telegram-bot-php/core?cacheSeconds=3600" alt="Downloads" /></a>
  <a href="https://packagist.org/packages/telegram-bot-php/core"><img src="https://img.shields.io/github/license/telegram-bot-php/core?cacheSeconds=3600" alt="License" /></a>
</p>

<br/>

# Telegram Bot PHP

This library is a simple and easy to use library for creating [Telegram API Bots](https://telegram.org/blog/bot-revolution), and this library is designed to provide a platform where one can simply write a bot and have interactions in a matter of minutes.

## Table of Contents

- [Introduction](#introduction)
  - [Installation](#installation)
  - [Getting started](#getting-started)
- [Webhook](#webhook)
    - [Use self-signed certificate](#use-self-signed-certificate)
    - [Delete webhook](#delete-webhook)
- [Update Handling](#update-handling)
    - [Anonymous plugins and handlers](#anonymous-plugins-and-handlers)
    - [Create a handler for updates](#create-a-handler-for-updates)
    - [Filter incoming updates](#filter-incoming-updates)
- [Plugins](#plugins)
    - [Create plugin for Handler class](#create-plugin-for-handler-class)
    - [Available events and methods](#available-events-and-methods)
- [Supports](#supports)
- [Logging](/docs/01-logging.md)
- [Error Handling](#error-handling)
- [Example bot](https://github.com/telegram-bot-php/example-of-usage)
- [Troubleshooting](#troubleshooting)
- [Code of Conduct](#code-of-conduct)
- [Contributing](#contributing)
- [License](#license)

## Introduction

This is an official announcement of support, which allows integrators of all sorts to bring automated interactions with
the [Telegram Bot API](https://core.telegram.org/bots/api) to their users.

This library features:

- The easiest and simplest way for [update handling](#update-handling)
- Support for all types and methods according
  to [Telegram Bot API 6.0](https://core.telegram.org/bots/api#available-methods)
- Handling `WebAppData` and data encryption/validation
- Crash handling and error reporting
- The ability to create advanced `Plugins` with their `asynchronous` methods
- The ability to manage Channels from the bot admin interface
- Downloading and uploading large files
- Full support for inline bots
- Inline keyboard support
- And many more...

### Installation

```ssh
composer require telegram-bot-php/core
```

<details>

<summary>Click for help with installation</summary>

## Install Composer

If the above step didn't work, install composer and try again.

#### Debian / Ubuntu

```
sudo apt-get install curl php-curl
curl -s https://getcomposer.org/installer | php
php composer.phar install
```

Composer not found? Use this command instead:

```
php composer.phar require "telegram-bot-php/core"
```

#### Windows:

[Download installer for Windows](https://getcomposer.org/doc/00-intro.md#installation-windows)

</details>

### Getting started

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$admin_id = 123456789;
$bot_token = 'your_bot_token';

\TelegramBot\Telegram::setToken($bot_token);
\TelegramBot\CrashPad::setDebugMode($admin_id);

$result = \TelegramBot\Request::sendMessage([
    'chat_id' => $admin_id,
    'text' => 'text',
]);

echo $result->getRawData(false); // {"ok": true, "result": {...}}
```

## Webhook

Create `set-hook.php` with the following contents:

```php
<?php
require __DIR__ . '/vendor/autoload.php';

\TelegramBot\Telegram::setToken($bot_token);
$response = \TelegramBot\Request::setWebhook([
    'url' => 'https://your-domain.com/webhook/' . $bot_token,
]);

if ($response->isOk()) {
    echo $response->getDescription();
    exit(0);
}
```

### Use self-signed certificate

```php
\TelegramBot\Request::setWebhook([
    'url' => 'https://your-domain.com/webhook/' . $bot_token,
    'certificate' => 'path/to/certificate.pem',
]);
```

### Delete webhook

```php
\TelegramBot\Request::deleteWebhook();
```

## Update Handling

### Create a handler for updates

```php
<?php

use TelegramBot\Entities\Update;
use TelegramBotTest\EchoBot\Plugins\MainPlugin;

class Handler extends \TelegramBot\UpdateHandler
{

    public function __process(Update $update): void
    {
        self::addPlugins([
            MainPlugin::class,
        ]);
    }

}
```

### Filter incoming updates

Filtering incoming updates by their type is easy.

```php
TelegramBot\UpdateHandler::filterIncomingUpdates([
    Update::TYPE_MESSAGE,
    Update::TYPE_CALLBACK_QUERY,
]);
```

Or just go advanced:

```php
TelegramBot\UpdateHandler::filterIncomingUpdates([
    Update::TYPE_MESSAGE => function (\TelegramBot\Entities\Update $update) {
        return $update->getMessage()->getChat()->getId() === 259760855;
    }
]);
```

## Plugins

The Plugins are a way to create a bot that can do more than just echo back the message.

### Create plugin for Handler class

```php
<?php
use TelegramBot\Entities\Message;
use TelegramBot\Entities\WebAppData;

class MainPlugin extends \TelegramBot\Plugin
{

    public function onMessage(int $update_id, Message $message): \Generator
    {
        if ($message->getText() === '/start') {
            yield \TelegramBot\Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => 'Hello, ' . $message->getFrom()->getFirstName(),
            ]);
        }
        
        if ($message->getText() === '/ping') {
            yield \TelegramBot\Request::sendMessage([
                'chat_id' => $message->getChat()->getId(),
                'text' => 'pong',
            ]);
        }
    }

    public function onWebAppData(int $update_id, WebAppData $webAppData): \Generator
    {
        yield \TelegramBot\Request::sendMessage([
            'chat_id' => $webAppData->getUser()->getId(),
            'text' => 'Hello, ' . $webAppData->getUser()->getFirstName(),
        ]);
    }

}
```

### Anonymous plugins and handlers

```php
<?php
declare(strict_types=1);

$commands = new class() extends \TelegramBot\Plugin {
    public function onUpdate(\TelegramBot\Entities\Update $update): \Generator
    {
        // Write your code here
    }
};

$admin = new class() extends \TelegramBot\Plugin {
    // TODO: Write your code here
};

(new \TelegramBot\UpdateHandler())->addPlugins([$commands, $admin])->resolve();
```

### Available events and methods

```php
class SomePlugin extends \TelegramBot\Plugin 
{

    public function onUpdate(Update $update): \Generator{}

    public function onMessage(int $update_id, Message $message): \Generator{}

    public function onEditedMessage(int $update_id, EditedMessage $editedMessage): \Generator{}

    public function onChannelPost(int $update_id, ChannelPost $channelPost): \Generator{}

    public function onEditedChannelPost(int $update_id, EditedChannelPost $editedChannelPost): \Generator{}

    public function onInlineQuery(int $update_id, InlineQuery $inlineQuery): \Generator{}

    public function onChosenInlineResult(int $update_id, ChosenInlineResult $chosenInlineResult): \Generator{}

    public function onCallbackQuery(int $update_id, CallbackQuery $callbackQuery): \Generator{}

    public function onShippingQuery(int $update_id, ShippingQuery $shippingQuery): \Generator{}

    public function onPreCheckoutQuery(int $update_id, PreCheckoutQuery $preCheckoutQuery): \Generator{}

    public function onPoll(int $update_id, Poll $poll): \Generator{}

    public function onPollAnswer(int $update_id, PollAnswer $pollAnswer): \Generator{}

    public function onWebAppData(int $update_id, WebAppData $webAppData): \Generator{}

}
```

## Supports

This library supports evey Telegram Bot API method and entity since [API version 6.0](https://core.telegram.org/bots/api#april-16-2022).

## Error Handling

Using CrashPad for reporting error through telegram. just add below to your Update handler.
```php
\TelegramBot\CrashPad::setDebugMode(259760855);
```

## Troubleshooting

Please report any bugs you find on the [issues page](https://github.com/telegram-bot-php/core/issues).

## Code of Conduct

The Telegram-Bot-PHP Code of Conduct can be found
at [this document](https://github.com/telegram-bot-php/core/blob/master/.github/CODE_OF_CONDUCT.md).

## Contributing

Thank you for considering contributing to this project. please open an issue or pull request if you have any suggestions
or just email [opensource@litehex.com](mailto:opensource@litehex.com).

## License

The Telegram-Bot-PHP library is open-sourced under
the [MIT license](https://github.com/telegram-bot-php/core/blob/master/LICENSE).