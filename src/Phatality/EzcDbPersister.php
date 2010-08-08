<?php

	namespace Phatality;

	use Phatality\Persistence\Connection;

	class EzcDbPersister implements Persister {

		private $connection;

		public function __construct(Connection $connection) {
			$this->connection = $connection;
		}

		public function insert(Entity $entity) {
			

		}
		
		public function update(Entity $entity) {}
		public function delete($id, $type) {}
		public function load($id, $type) {}
		public function fetchAll($id, $type) {}
		public function insertOrUpdate(Entity $entity) {}
		public function replace(Entity $entity) {}

		public function getConnection() {
			return $this->connection;
		}
	}
	
?>