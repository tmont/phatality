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

		/**
		 * Converts a string to the specified type
		 * 
		 * @throws InvalidArgumentException
		 * @param string $string
		 * @param string $type
		 * @return bool|int|string
		 */
		public static function convertString($string, $type) {
			switch($type) {
				case 'int':
			    case 'integer':
			        return (int)$string;
				case 'bool':
			    case 'boolean':
			        return ($string === '0' || $string === 'false') ? false : true;
				case 'string':
			        return $string;
				default:
			        throw new InvalidArgumentException('Cannot convert string to type ' . $type);
			}
		}

		/**
		 * @param string $type
		 * @return object
		 */
		public static function createEntityInstance($type) {
			//TODO This should be factored out into an overridable factory interface
			$class = ReflectionCache::getClass($type);
			return $class->newInstanceArgs();
		}

		public static function parseDataByPrefix(array $data, $prefix, $changeTo = '') {
			$parsed = array();
			foreach ($data as $key => $value) {
				if (strpos($key, $prefix . '.') === 0) {
					$parsed[str_replace($prefix . '.', empty($changeTo) ? '' : $changeTo . '.', $key)] = $value;
				}
			}

			return $parsed;
		}
	
	}

?>