<?php

	namespace Phatality;

	use Phatality\Persistence\PersisterEvent;

	class InsertEvent implements PersisterEvent, CommandContext {

		private $returnValue;
		private $entity;
		private $session;
		private $canceled = false;

		public function __construct(Entity $entity, Session $session) {
			$this->entity = $entity;
			$this->session = $session;
		}

		public function getEntity() {
			return $this->entity;
		}

		public function getSession() {
			return $this->session;
		}

		public function getReturnValue() {
			return $this->returnValue;
		}

		public function setReturnValue($returnValue) {
			$this->returnValue = $returnValue;
		}

		public function cancel() {
			$this->canceled = true;
		}

		public function shouldProceed() {
			return $this->canceled === false;
		}
	}

?>
