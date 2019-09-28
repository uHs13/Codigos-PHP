<?php
namespace Hcode\Utils;

class Utils
{

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

}
//.Utils