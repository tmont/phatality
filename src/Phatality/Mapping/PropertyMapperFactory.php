<?php

	namespace Phatality\Mapping;
	
	interface PropertyMapperFactory {
		
		/**
		 * @param string $mapperType
		 * @param object $entity
		 * @param EntityMap $entityMap
		 * @return PropertyMapper
		 */
		function getPropertyMapper($mapperType, $entity, EntityMap $entityMap);
	}

?>