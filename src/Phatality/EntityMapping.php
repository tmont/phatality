<?php

	namespace Phatality;

	use Serializable;

	class EntityMapping implements Serializable, IdGeneratorFactory {

		private $persisterRegistry;
		private $entityInfo;

		public function __construct(EntityInfo $info, PersisterRegistry $persisterRegistry) {
			$this->persisterRegistry = $persisterRegistry;
			$this->entityInfo = $info;
		}

		/**
		 * @return Persister
		 */
		public function getPersister() {
			return $this->persisterRegistry->getOrCreatePersister($this->entityInfo->getPersisterType());
		}

		/**
		 * @ignore
		 */
		public function serialize() {
			return serialize(
				array(
					'info' => $this->entityInfo,
					'registry' => $this->persisterRegistry
				)
			);
		}

		public function unserialize($serialized) {
			$data = unserialize($serialized);
			$this->persisterRegistry = $data['registry'];
			$this->entityInfo = $data['info'];
		}

		/**
		 * @return IdGenerator
		 */
		public function getIdGenerator() {
			return $this->entityInfo->getIdGenerator();
		}

	}

?>