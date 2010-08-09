<?php

	namespace Phatality\Mapping;

	class MagicMethodPropertySetter implements PropertySetter {

		public function set($object, $propertyName, $value) {
			$object->$propertyName = $value;
		}

	}

?>