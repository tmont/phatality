<?php

	namespace Phatality;

	use ReflectionClass, ReflectionProperty;

	final class ReflectionCache {

		private static $classes = array();
		private static $properties = array();

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

		/**
		 * @param string|object $objectOrClassName
		 * @param string $propertyName
		 * @return ReflectionProperty
		 */
		public static function getProperty($objectOrClassName, $propertyName) {
			$key = is_object($objectOrClassName) ? get_class($objectOrClassName) : $objectOrClassName;
			$key .= '::' . $propertyName;
			
			if (!isset(self::$properties[$key])) {
				self::$properties[$key] = new ReflectionProperty($objectOrClassName, $propertyName);
			}

			return self::$properties[$key];
		}

	}
	
?>