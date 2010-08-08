<?php

	namespace Phatality;

	class AccessorMethodPropertySetter implements PropertySetter {

		public function set($object, $propertyName, $value) {
			$class = ReflectionCache::getClass(get_class($object));
			$class->getMethod(self::propertyToMethod($propertyName))->invoke($object, $value);
		}

		private static function propertyToMethod($propertyName) {
			return 'set' . ucfirst($propertyName);
		}

	}
	
?>