<?php

	namespace Phatality\Mapping;

	class PublicFieldPropertySetter implements PropertySetter {

		public function set($object, $propertyName, $value) {
			$object->$propertyName = $value;
		}

	}

?>