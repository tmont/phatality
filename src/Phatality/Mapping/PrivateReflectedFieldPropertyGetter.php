<?php

	namespace Phatality\Mapping;

	use Phatality\ReflectionCache;

	class PrivateReflectedFieldPropertyGetter implements PropertyGetter {

		public function get($object, $propertyName) {
			$property = ReflectionCache::getProperty($object, $propertyName);
			$property->setAccessible(true);
			return $property->getValue($object);
		}
	}
	
?>