<?php

	namespace Phatality;

	use Phatality\Persistence\PersisterEvent;

	class LoadEvent implements PersisterEvent, CommandContext {

		private $returnValue;
		private $entityType;
		private $entityId;
		private $session;
		private $canceled = false;

		public function __construct($entityId, $entityType, Session $session) {
			$this->entityId = $entityId;
			$this->entityType = $entityType;
			$this->session = $session;
		}

		public function getEntityType() {
			return $this->entityType;
		}

		public function getEntityId() {
			return $this->entityId;
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
