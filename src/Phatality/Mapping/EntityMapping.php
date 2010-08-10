<?php

	namespace Phatality\Mapping;

	use Serializable;
	use Phatality\Id\IdGeneratorFactory;
	use Phatality\Persistence\PersisterRegistry;
	use Phatality\Id\StaticIdGeneratorFactory;
	use Phatality\Util;

	abstract class EntityMapping implements Serializable, IdGeneratorFactory {

		private $persisterRegistry;
		private $idGenerator;
		private $sourceData;
		private $propertyMapperFactory;

		const ThisPrefix = '_this';

		protected function __construct(SourceData $sourceData, PersisterRegistry $persisterRegistry, PropertyMapperFactory $mapperFactory = null) {
			$this->persisterRegistry = $persisterRegistry;
			$this->sourceData = $sourceData;
			$this->propertyMapperFactory = $mapperFactory ?: new DefaultPropertyMapperFactory();
		}

		/**
		 * @return Persister
		 */
		public function getPersister() {
			return $this->persisterRegistry->getOrCreatePersister($this->sourceData->getPersisterType());
		}

		/**
		 * @param object $entity
		 * @param array $data
		 * @param EntityMap $entityMap
		 * @return object
		 */
		public function loadEntity($entity, array $data, EntityMap $entityMap) {
			$columnMappings = $this->getColumnMappings();
			$accessorFactory = new PropertyAccessorFactory();
			$defaultSetter = $accessorFactory->getSetter($this->getDefaultSetterType());

			$propertyMapper = $this->propertyMapperFactory->getPropertyMapper(MapperType::Property, $entity, $entityMap);
			$manyToOneMapper = $this->propertyMapperFactory->getPropertyMapper(MapperType::ManyToOne, $entity, $entityMap);

			foreach (Util::parseDataByPrefix($data, self::ThisPrefix) as $column => $value) {
				if (!isset($columnMappings[$column])) {
					continue;
				}

				$mapData = $columnMappings[$column];
				$setter = isset($mapData['setter']) ? $accessorFactory->getSetter($mapData['setter']) : $defaultSetter;
				$targetType = isset($mapData['type']) ? $mapData['type'] : 'string';

				switch ($mapData['mapping']) {
					case MapperType::Property:
						$propertyMapper->map($mapData['name'], $value, $targetType, $setter, $data);
						break;
					case MapperType::ManyToOne:
						$manyToOneMapper->map($mapData['name'], $value, $targetType, $setter, $data);
						break;
					default:
						throw new Exception('Not implemented yet');
				}
			}

			return $entity;
		}

		/**
		 * @return array
		 */
		protected abstract function getColumnMappings();

		public abstract function getEntityType();

		protected abstract function getIdGeneratorType();

		protected abstract function getDefaultGetterType();

		protected abstract function getDefaultSetterType();

		public abstract function getJoinAlias();

		public function getSourceData() {
			return $this->sourceData;
		}

		/**
		 * @ignore
		 */
		public function serialize() {
			return serialize(
				array(
					'registry' => $this->persisterRegistry,
					'sourceData' => $this->sourceData
				)
			);
		}

		public function unserialize($serialized) {
			$data = unserialize($serialized);
			$this->persisterRegistry = $data['registry'];
			$this->sourceData = $data['sourceData'];
		}

		public function getIdGenerator() {
			if ($this->idGenerator === null) {
				$this->idGenerator = StaticIdGeneratorFactory::getIdGenerator($this->getIdGeneratorType(), array($this->sourceData));
			}

			return $this->idGenerator;
		}

	}

	?>