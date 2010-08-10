<?php

	namespace Phatality\Mapping;

	use InvalidArgumentException;
	
	class DefaultPropertyMapperFactory implements PropertyMapperFactory {

		public function getPropertyMapper($mapperType, $entity, EntityMap $entityMap) {
			switch ($mapperType) {
				case MapperType::Property:
			        return new DirectValueMapper($entity);
				case MapperType::ManyToOne:
			        return new ManyToOneMapper($entity, $entityMap);
				default:
			        throw new InvalidArgumentException('Unknown property mapper type: ' . $mapperType);
			}
		}
	}

?>