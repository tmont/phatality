<?php

	namespace Phatality\Mapping;

	use Phatality\ReflectionCache;

	class PrivateReflectedFieldPropertySetter implements PropertySetter {

		public function set($object, $propertyName, $value) {
			$property = ReflectionCache::getProperty($object, $propertyName);
			$property->setAccessible(true);
			$property->setValue($object, $value);
		}
	}

?>