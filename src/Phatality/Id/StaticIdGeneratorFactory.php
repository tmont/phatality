<?php

	namespace Phatality\Id;

	use InvalidArgumentException, ReflectionClass;

	class StaticIdGeneratorFactory {

		private static $idGeneratorInterface = 'Phatality\Id\IdGenerator';

		public static function getIdGenerator($type, array $args = array()) {
			if (!class_exists($type)) {
				throw new InvalidArgumentException(sprintf('The type "%s" does not exist'), $type);
			}

			$refClass = new ReflectionClass($type);
			if (!$refClass->implementsInterface(self::$idGeneratorInterface)) {
				throw new InvalidArgumentException(sprintf('The type "%s" does not implement %s', $type, self::$idGeneratorInterface));
			}

			return $refClass->newInstanceArgs($args);
		}
	}
	
?>