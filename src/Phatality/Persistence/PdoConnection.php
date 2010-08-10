<?php

	namespace Phatality\Persistence;

	use PDO;

	class PdoConnection implements Connection {

		private $pdo;

		public function __construct(PDO $pdo) {
			$this->pdo = $pdo;
		}

		public function connect() {
			throw new BadMethodCallException('Cannot reconnect to a PDO instance');
		}

		public function disconnect() {
			$this->pdo = null;
		}

		public function isValid() {
			return $this->pdo !== null;
		}

		/**
		 * @param string $query
		 * @return DbStatement
		 */
		public function prepare($query) {
			return new DbStatement($this->pdo->prepare($query));
		}

		public function beginTransaction() {
			return $this->pdo->beginTransaction();
		}

		public function commit() {
			return $this->pdo->commit();
		}

		public function rollback() {
			return $this->pdo->rollback();
		}
	}
	
?>