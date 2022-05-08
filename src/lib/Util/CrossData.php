<?php

namespace TelegramBot\Util;

/**
 * Class CrossData
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class CrossData
{

	/**
	 * get CrossData
	 *
	 * @param string $key
	 * @return string|array|bool|null
	 */
	public static function get(string $key): string|array|bool|null
	{
		$data = json_decode(getenv('TG_CROSS_DATA'), true);
		$block = 'TG_CROSS_DATA' . $key;

		if (!isset($data[$key])) {
			return null;
		}

		return getenv($data[$block]);
	}

	/**
	 * put CrossData
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public static function put(string $key, mixed $value): void
	{
		$data = json_decode(getenv('TG_CROSS_DATA'), true);
		$data[$key] = 'TG_CROSS_DATA_' . $key;
		putenv($data[$key] . '=' . $value);
		putenv(json_encode($data));
	}

}