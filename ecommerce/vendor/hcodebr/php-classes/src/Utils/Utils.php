<?php
namespace Hcode\Utils;

use Hcode\Model\Cart;

class Utils
{

	const SESSION_ERROR = "sessionError";
	const SESSION_SUCCESS = "sessionSuccess";

	//---- GETTERS AND SETTERS ----\\

	public static function setSessionMsgError($msg)
	{

		$_SESSION[Utils::SESSION_ERROR] = $msg;

	}
	//.setMsgError

	public static function setSessionMsgSuccess($msg)
	{

		$_SESSION[Utils::SESSION_SUCCESS] = $msg;

	}
	//.setMsgError

	public static function getSessionMsgError()
	{

		$msg = (isset($_SESSION[Utils::SESSION_ERROR]) && $_SESSION[Utils::SESSION_ERROR]) ? $_SESSION[Utils::SESSION_ERROR] : "";

		//var_dump(isset($_SESSION[Utils::SESSION_ERROR]), $_SESSION[Utils::SESSION_ERROR]);

		self::clearSessionMsgError();

		return $msg;

	}
	//.getMsgError

	public static function getSessionMsgSuccess()
	{

		$msg = (isset($_SESSION[Utils::SESSION_SUCCESS]) && $_SESSION[Utils::SESSION_SUCCESS]) ? $_SESSION[Utils::SESSION_SUCCESS] : "";

		//var_dump(isset($_SESSION[Utils::SESSION_ERROR]), $_SESSION[Utils::SESSION_ERROR]);

		self::clearSessionMsgSuccess();

		return $msg;

	}
	//.getMsgError

	//---- GETTERS AND SETTERS ----\\

	public static function clearSessionMsgError()
	{

		$_SESSION[Utils::SESSION_ERROR] = null;

	}
	//.clearSessionMsgError

	public static function clearSessionMsgSuccess()
	{

		$_SESSION[Utils::SESSION_SUCCESS] = null;

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

	public static function encrypt($str)
	{

		return password_hash($str, PASSWORD_DEFAULT, [

			"cost"=>12

		]);

	}
	//.encrypt

	public static function hash($str)
	{

		self::safeEntry($str);

		return password_hash($str, PASSWORD_DEFAULT, [

			"cost"=>12

		]);

	}
	// .hash

}
//.Utils