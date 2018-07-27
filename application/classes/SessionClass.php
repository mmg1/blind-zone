<?php

namespace Blind;

class Session extends Main
{
	public static function sessionRegenerate()
	{
		// session fixation prevent
		return session_regenerate_id(true);
	}

	public static function sessionDestroy($sessionKey)
	{
		session_unset();
		unset($_SESSION[$sessionKey]);
		$result = session_destroy();

		return $result;
	}
}
