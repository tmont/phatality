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

		protected function __construct(SourceData $sourceData, PersisterRegistry $persisterRegistry) {
			$this->persisterRegistry = $persisterRegistry;
			$this->sourceData = $sourceData;
		}

		/**
		 * @return Persister
		 */
		public function getPersister() {
			return $this->persisterRegistry->getOrCreatePersister($this->sourceData->getPersisterType());
		}

		/**
		 * @param object $object
		 * @param array $data
		 * @return object
		 */
		public function loadEntity($object, array $data, EntityMap $entityMap) {
			$columnMappings = $this->getColumnMappings();
			$accessorFactory = new PropertyAccessorFactory();
			$defaultSetter = $accessorFactory->getSetter($this->getDefaultSetterType());

			$defaultType = 'string';
			foreach (self::parseDataByPrefix($data, '_this') as $column => $value) {
				if (!isset($columnMappings[$column])) {
					continue;
				}

				$mapData = $columnMappings[$column];
				$setter = isset($mapData['setter']) ? $accessorFactory->getSetter($mapData['setter']) : $defaultSetter;
				$targetType = isset($mapData['type']) ? $mapData['type'] : $defaultType;

				switch ($mapData['mapping']) {
					case 'property':
						$setter->set($object, $mapData['name'], Util::convertString($value, $targetType));
						break;
					case 'many-to-one':
						$targetObject = Util::createEntityInstance($targetType);
						$joinedEntityMap = $entityMap[$targetType];
						$joinData = self::parseDataByPrefix($data, $joinedEntityMap->getJoinAlias(), '_this');
						$joinKey = $joinedEntityMap->getSourceData()->getPrimaryKeys();
						if (count($joinKey) !== 1) {
							throw new MappingException(
								sprintf(
									'Invalid primary key for entity "%s": cannot establish many-to-one relationship with entity "%s" because a suitable key was not found',
									$targetType,
									get_class($object)
								)
							);
						}

						$joinData['_this.' . $joinKey[0]->name] = $value; //set the join column value
						$setter->set($object, $mapData['name'], $joinedEntityMap->loadEntity($targetObject, $joinData, $entityMap));
						break;
					default:
						throw new Exception('Not implemented yet');
				}
			}

			return $object;
		}

		private static function parseDataByPrefix(array $data, $prefix, $changeTo = '') {
			$parsed = array();
			foreach ($data as $key => $value) {
				if (strpos($key, $prefix . '.') === 0) {
					$parsed[str_replace($prefix . '.', empty($changeTo) ? '' : $changeTo . '.', $key)] = $value;
				}
			}

			return $parsed;
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