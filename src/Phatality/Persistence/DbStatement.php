<?php

	namespace Phatality\Persistence;

	use PDO, PDOStatement;

	class DbStatement implements Statement {

		private $statement;

		public function __construct(PDOStatement $statement) {
			$this->statement = $statement;
		}

		public function execute(array $parameters = array()) {
			return $this->statement->execute($parameters);
		}

		public function fetchColumn($index) {
			return $this->statement->fetchColumn($index);
		}

		public function fetchNextRow() {
			return $this->statement->fetch(PDO::FETCH_ASSOC);
		}

		public function fetchNextRowInto($type) {
			throw new BadMethodCallException('Not implemented yet');
		}

		public function fetchRowAt($index) {
			throw new BadMethodCallException('Not implemented yet');
		}

		public function fetchAll() {
			return $this->statement->fetchAll(PDO::FETCH_ASSOC);
		}
	}
	
?>