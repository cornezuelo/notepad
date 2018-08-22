<?php
//Encryption CLASS
class Encryption {
	private static $method = "AES-128-CBC";
	public static function encrypt($txt) {
		global $config;
		return @openssl_encrypt ( $txt , self::$method , $config['hash']);
	}
	
	public static function decrypt($txt) {
		global $config;
		return @openssl_decrypt ( $txt , self::$method , $config['hash']);
	}
}
?>	
