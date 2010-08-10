<?php

	namespace Phatality\Mapping;
	
	class CollectionMapper implements PropertyMapper {

		private $entity;
		private $entityMap;
		private $collector;

		public function __construct($entity, EntityMap $entityMap, DataCollector $collector) {
			$this->entity = $entity;
			$this->entityMap = $entityMap;
			$this->collector = $collector;
		}

		public function map($propertyName, $sourceId, $targetType, PropertySetter $setter, array $data) {
			$collection = array();

			$mapping = $this->entityMap[$targetType];
			$primaryKeys = $mapping->getSourceData()->getPrimaryKeys();

			$constraints = array(
				$primaryKeys[0] => $sourceId
			);

			$collectionData = $this->collector->collectData($data, $mapping, $constraints);

			foreach ($collectionData as $row) {
				$collection[] = $mapping->loadEntity($this->entity, Util::parseDataByPrefix($row, $mapping->getJoinAlias()), $this->entityMap);
			}

			$setter->set($this->entity, $propertyName, $collection);
		}

	}

?>