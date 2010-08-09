<?php

	namespace Phatality\Mapping;

	class MagicMethodPropertyGetter implements PropertyGetter {

		public function get($object, $propertyName) {
			return $object->$propertyName;
		}

	}

?>