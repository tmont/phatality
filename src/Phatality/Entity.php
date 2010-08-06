<?php

	namespace Phatality;

	class Entity {

		private $object;
		private $objectId;
		private $type;
		private $mapping;

		public function __construct($object, $id) {
			$this->object = $object;
			$this->objectId = $id;
			$this->type = get_class($object);
		}

		public function getObject() {
			return $this->object;
		}

		public function getId() {
			return $this->objectId;
		}

		public function getType() {
			return $this->type;
		}

	}
	
?>