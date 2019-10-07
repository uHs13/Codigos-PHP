<?php
namespace Hcode\Utils;

use Hcode\Model\Cart;

class Utils
{

	const SESSION_ERROR = "sessionError";

	//---- GETTERS AND SETTERS ----\\

	public static function setSessionMsgError($msg)
	{

		$_SESSION[Utils::SESSION_ERROR] = $msg;

	}
	//.setMsgError

	public static function getSessionMsgError()
	{

		$msg = (isset($_SESSION[Utils::SESSION_ERROR]) && $_SESSION[Utils::SESSION_ERROR]) ? $_SESSION[Utils::SESSION_ERROR] : "";

		self::clearSessionMsgError();

		return $msg;

	}
	//.getMsgError

	//---- GETTERS AND SETTERS ----\\

	public static function clearSessionMsgError()
	{

		$_SESSION[Utils::SESSION_ERROR] = null;

	}
	//.clearSessionMsgError

	public static function safeEntry(&$element)
	{

		switch (gettype($element)) {

			case "array":

			foreach ($element as &$value) {

				$value = escapeshellcmd(strip_tags(trim($value)));

			}

			break;

			default:

			$element = escapeshellcmd(strip_tags(trim($element)));

			break;

		}

		return $element;

	}
	//.safeEnty

	public static function formatValueToDBDecimal($str):float
	{

		$str = str_replace(".", "", $str);

		return str_replace(",", ".", $str);

	}
	//.formatValueToDecimal

	public static function redirect($path)
	{

		header("Location: $path");
		exit;

	}
	//.redirect

}
//.Utils