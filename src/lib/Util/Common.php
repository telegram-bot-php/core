<?php

namespace TelegramBot\Util;

/**
 * Class Common
 *
 * @link    https://github.com/telegram-bot-php/core
 * @author  Shahrad Elahi (https://github.com/shahradelahi)
 * @license https://github.com/telegram-bot-php/core/blob/master/LICENSE (MIT License)
 */
class Common
{

	/**
	 * Validate the given string is JSON or not
	 *
	 * @param ?string $string
	 * @return bool
	 */
	public static function isJson(?string $string): bool
	{
		if (!is_string($string)) {
			return false;
		}

		json_decode($string);

		return json_last_error() === JSON_ERROR_NONE;
	}

	/**
	 * Check string is a url encoded string or not
	 *
	 * @param ?string $string
	 * @return bool
	 */
	public static function isUrlEncode(?string $string): bool
	{
		if (!is_string($string)) {
			return false;
		}

		return preg_match('/%[0-9A-F]{2}/i', $string);
	}

	/**
	 * Convert url encoded string to array
	 *
	 * @param string $string
	 * @return array
	 */
	public static function urlDecode(string $string): array
	{
		$raw_data = explode('&', urldecode($string));
		$data = [];

		foreach ($raw_data as $row) {
			[$key, $value] = explode('=', $row);

			if (self::isUrlEncode($value)) {
				$value = urldecode($value);
				if (self::isJson($value)) {
					$value = json_decode($value, true);
				}
			}

			$data[$key] = $value;
		}

		return $data;
	}

}