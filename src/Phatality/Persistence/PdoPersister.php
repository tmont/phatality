<?php

	namespace Phatality\Persistence;

	use Phatality\Entity;

	class PdoPersister implements Persister {

		private $connection;

		public function __construct(Connection $connection) {
			$this->connection = $connection;
		}

		public function insert(Entity $entity) {
			

		}
		
		public function update(Entity $entity) {}
		public function delete($id, $type) {}
		public function load($id, $type) {}
		public function fetchAll($type) {}
		public function insertOrUpdate(Entity $entity) {}
		public function replace(Entity $entity) {}

		public function getConnection() {
			return $this->connection;
		}
	}
	
?>