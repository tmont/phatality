<?php

	namespace Phatality;

	class Entity {

		private $object;
		private $type;
		private $mapping;

		public function __construct(Identifiable $object, EntityMapping $mapping) {
			$this->object = $object;
			$this->type = get_class($object);
			$this->mapping = $mapping;
		}

		public function getObject() {
			return $this->object;
		}

		public function getType() {
			return $this->type;
		}

		public function getMapping() {
			return $this->mapping;
		}

		public function requiresIdOnInsert() {
			return $this->mapping->getIdGenerator()->requiresIdOnInsert();
		}

		/**
		 * @param Session $session
		 * @return mixed
		 */
		public function generateId(Session $session) {
			return $this->mapping->getIdGenerator()->generateId($session, $this->object);
		}

	}
	
?>