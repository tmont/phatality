<?php

	namespace Phatality;

	use Serializable;

	class EntityMapping implements Serializable {

		private $persisterType;
		private $persisterRegistry;
		private $type;

		public function __construct($type, $persisterType, PersisterRegistry $persisterRegistry) {
			$this->type = $type;
			$this->persisterType = $persisterType;
			$this->persisterRegistry = $persisterRegistry;
		}

		/**
		 * @return Persister
		 */
		public function getPersister() {
			return $this->persisterRegistry->getOrCreatePersister($this->persisterType);
		}

		/**
		 * @ignore
		 */
		public function serialize() {
			return serialize(
				array(
					'type' => $this->type,
					'persister' => $this->persisterType,
					'registry' => $this->persisterRegistry
				)
			);
		}

		public function unserialize($serialized) {
			$data = unserialize($serialized);
			$this->type = $data['type'];
			$this->persisterType = $data['persister'];
			$this->persisterRegistry = $data['registry'];
		}
	}

?>