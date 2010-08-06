<?php

	namespace Phatality;

	final class Util {
		
		private function __construct() { }
		
		/**
		 * Generates a UUID according to RFC 4122
		 *
		 * @link http://www.php.net/manual/en/function.uniqid.php#69164
		 *
		 * @return string A UUID, made up of 32 hex digits and 4 hyphens
		 */
		public static function generateId() {
			return sprintf( 
				'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff),
				mt_rand(0, 0x0fff) | 0x4000,
				mt_rand(0, 0x3fff) | 0x8000,
				mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff) 
			); 
		}
	
	}

?>