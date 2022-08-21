<p align="center">
<img src="logo.png" alt="logo" width="200" height="200"/>
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

Someday I will write documentation for this library, but for now, you can use it and see how it works.

## Introduction

Some documentation will be written here soon.

#### Installation

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

#### Getting started

```php
<?php
require __DIR__ . '/vendor/autoload.php';

$admin_id = 123456789;
$bot_token = 'your_bot_token';

$telegram = new \TelegramBot\Telegram($bot_token);
$telegram->setAdmin($admin_id);

$result = Request::sendMessage([
    'chat_id' => $admin_id,
    'text' => 'text',
]);

echo $result->getRawData(false); // {"ok": true, "result": {...}}
```

## Code of Conduct

The Telegram-Bot-PHP Code of Conduct can be found
at [this document](https://github.com/telegram-bot-php/core/blob/master/.github/CODE_OF_CONDUCT.md).

## Contributing

Thank you for considering contributing to this project. please open an issue or pull request if you have any suggestions
or just email [opensource@litehex.com](mailto:opensource@litehex.com).

## License

The Telegram-Bot-PHP library is open-sourced under
the [MIT license](https://github.com/telegram-bot-php/core/blob/master/LICENSE).