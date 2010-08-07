<?php

	namespace Phatality;

	use ezcDbHandler;

	class EzcDbPersister implements Persister {

		private $dbh;

		public function __construct(ezcDbHandler $dbh) {
			$this->dbh = $dbh;
		}

		public function insert(Entity $entity) {
			

		}
		
		public function update(Entity $entity) {}
		public function delete($id, $type) {}
		public function load($id, $type) {}
		public function fetchAll($id, $type) {}
		public function insertOrUpdate(Entity $entity) {}
		public function replace(Entity $entity) {}
	}
	
?>