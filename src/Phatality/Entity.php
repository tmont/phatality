<?php

	namespace Phatality;


	class Entity {

		private $object;
		private $type;

		public function __construct($object) {
			$this->object = $object;
			$this->type = get_class($object);
		}

		public function getObject() {
			return $this->object;
		}

		public function getType() {
			return $this->type;
		}

	}
	
?>