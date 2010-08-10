<?php

	namespace Phatality\Mapping;

	use Phatality\Util;
	
	class ManyToOneMapper implements PropertyMapper {

		private $entity;
		private $entityMap;

		public function __construct($entity, EntityMap $entityMap) {
			$this->entity = $entity;
			$this->entityMap = $entityMap;
		}

		public function map($propertyName, $targetId, $targetType, PropertySetter $setter, array $data) {
			$targetObject = Util::createEntityInstance($targetType);
			$joinedEntityMap = $this->entityMap[$targetType];
			$joinData = Util::parseDataByPrefix($data, $joinedEntityMap->getJoinAlias(), EntityMapping::ThisPrefix);
			$joinKey = $joinedEntityMap->getSourceData()->getPrimaryKeys();
			if (count($joinKey) !== 1) {
				throw new MappingException(
					sprintf(
						'Invalid primary key for entity "%s": cannot establish many-to-one relationship with entity "%s" because a suitable key was not found',
						$targetType,
						get_class($this->entity)
					)
				);
			}

			$joinData[EntityMapping::ThisPrefix . '.' . $joinKey[0]->name] = $targetId; //set the join column value
			$setter->set($this->entity, $propertyName, $joinedEntityMap->loadEntity($targetObject, $joinData, $this->entityMap));
		}

	}

?>