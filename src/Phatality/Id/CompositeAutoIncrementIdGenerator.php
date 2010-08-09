<?php

	namespace Phatality\Id;

	class CompositeAutoIncrementIdGenerator implements IdGenerator {

		private $pkColumns;
		private $incrementColumn;
		private $table;
		private static $next = array();

		public function __construct(array $pkColumns, $incrementColumn, $table) {
			$this->pkColumns = $pkColumns;
			$this->incrementColumn = $incrementColumn;
			$this->table = $table;
		}

		public function generateId(Session $session, $entity) {
			$id = (array)$entity->getId();
			$type = get_class($entity);
			$this->verifyId($id, $type);


//			if (isset(self::$next[$type])) {
//
//			}
//
//			if ($this-$next === null) {
//				$conn = $session->getPersister($type)->getConnection();
//				$query = sprintf('select max(%s) from %s', $this->incrementColumn, $this->table);
//				$this->next = (int)$conn->prepare($query)->fetchColumn(0);
//			}
//
//			return ++$this->next;

			return 0;
		}

		private function verifyId(array $id, $type) {
			foreach ($this->pkColumns as $column) {
				if (!isset($id[$column])) {
					throw new InvalidIdException(sprintf('The id for the class "%s" does not match the primary key columns given to %s', $type, __CLASS__));
				}
			}
		}

		public function requiresIdOnInsert() {
			return false;
		}
	}
	
?>