<?php
//Encryption CLASS
class Encryption {
	private static $hash = "z`7^9G_Y7HGs,L48mEgHZe5D#?Fba]M=";
	private static $method = "AES-128-CBC";
	public static function encrypt($txt) {
		return @openssl_encrypt ( $txt , self::$method , self::$hash);
	}
	
	public static function decrypt($txt) {
		return @openssl_decrypt ( $txt , self::$method , self::$hash);
	}
}
?>	