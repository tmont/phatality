<?php

	namespace Phatality;

	class EntityInfo implements Serializable, IdGeneratorFactory {

		private $entityType;
		private $persisterType;
		private $idGeneratorType;
		private $idGenerator;
		private $mappingInfo;

		public function __construct($entityType, $persisterType, $idGeneratorType, MappingInfo $mappingInfo) {
			$this->entityType = $entityType;
			$this->persisterType = $persisterType;
			$this->idGeneratorType = $idGeneratorType;
			$this->mappingInfo = $mappingInfo;
		}

		public function serialize() {
			return serialize(
				array(
					'entityType' => $this->entityType,
					'persisterType' => $this->persisterType,
					'idGeneratorType' => $this->idGeneratorType,
					'mappingInfo' => $this->mappingInfo,
				)
			);
		}

		public function unserialize($serialized) {
			$data = unserialize($serialized);
			$this->entityType = $data['entityType'];
			$this->persisterType = $data['persisterType'];
			$this->idGeneratorType = $data['idGeneratorType'];
			$this->mappingInfo = $data['mappingInfo'];
		}

		public function getIdGenerator() {
			if ($this->idGenerator === null) {
				$this->idGenerator = StaticIdGeneratorFactory::getIdGenerator($this->idGeneratorType, array($this->mappingInfo));
			}

			return $this->idGenerator;
		}

		public function getPersisterType() {
			return $this->persisterType;
		}

		public function getEntityType() {
			return $this->entityType;
		}

	}
	
?>