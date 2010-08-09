<?php

	namespace Phatality\Mapping;

	use Serializable;
	use Phatality\Id\IdGeneratorFactory;
	use Phatality\PersisterRegistry;
	use Phatality\Id\StaticIdGeneratorFactory;

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

		public function loadEntity($entity, array $data) {
			$columnMapping = $this->getColumnMappings();

			foreach ($data as $column => $value) {
				
			}
		}

		/**
		 * @return array
		 */
		protected abstract function getColumnMappings();

		public abstract function getEntityType();
		protected abstract function getIdGeneratorType();

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