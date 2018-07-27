<?php

namespace Blind;

class User extends Main {

	// check credentials for register and login forms
	public static function checkName($username) {

		$username = mb_strtolower(trim($username));
		
		if (Main::validate('/^[a-z][a-z0-9]{1,20}$/', $username))
			return false;

		return $username;
	}

	// get hash of password and salt
	public static function getHash($algo, $password, $salt) {
		if (!$salt)
			return false;

		// password then salt technic was vuln
		return hash($algo, $password.$salt);
	}

	// generate salt for password
	public static function saltGenerate() {
		$strong = True;
		$bytes = openssl_random_pseudo_bytes(32, $strong);
		if ($bytes) {
			$hex = bin2hex($bytes);
			$salt = substr($hex, 0, 32);

			return $salt;
		}

		return false;
	}

	public static function checkEmail($email) {
		$email = trim($email);
		if (filter_var($email, FILTER_VALIDATE_EMAIL) && mb_strlen($email) >= 6 && mb_strlen($email) <= 1024)
			return $email;

		return false;
	}
}
