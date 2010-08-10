<?php

	namespace Phatality\Mapping;
	
	interface PropertyMapper {
		function map($propertyName, $propertyValue, $targetType, PropertySetter $setter, array $data);
	}

?>