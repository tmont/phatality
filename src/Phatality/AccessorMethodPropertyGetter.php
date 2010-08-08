<?php

	namespace Phatality;

	class AccessorMethodPropertyGetter implements PropertyGetter {

		public function get($object, $propertyName) {
			$class = ReflectionCache::getClass(get_class($object));
			$method = $class->getMethod(self::propertyToMethod($propertyName));
			return $method->invoke($object);
		}

		private static function propertyToMethod($propertyName) {
			return 'get' . ucfirst($propertyName);
		}
	}
	
?>