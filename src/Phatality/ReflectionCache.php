<?php

	namespace Phatality;

	final class ReflectionCache {

		private static $classes = array();

		private function __construct() {}

		/**
		 * @param string $className
		 * @return ReflectionClass
		 */
		public static function getClass($className) {
			if (!isset(self::$classes[$className])) {
				self::$classes[$className] = new ReflectionClass($className);
			}

			return self::$classes[$className];
		}

	}
	
?>