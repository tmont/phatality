<?php

	namespace Phatality\Mapping;

	class PublicFieldPropertyGetter implements PropertyGetter {

		public function get($object, $propertyName) {
			return $object->$propertyName;
		}

	}

?>