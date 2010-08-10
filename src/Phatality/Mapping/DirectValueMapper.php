<?php

	namespace Phatality\Mapping;

	use Phatality\Util;
	
	class DirectValueMapper implements PropertyMapper {

		private $entity;

		public function __construct($entity) {
			$this->entity = $entity;
		}

		public function map($propertyName, $propertyValue, $targetType, PropertySetter $setter, array $data) {
			$setter->set($this->entity, $propertyName, Util::convertString($propertyValue, $targetType));
		}

	}

?>