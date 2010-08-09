<?php

	namespace Phatality\Id;

	class AutoIncrementIdGenerator implements IdGenerator {

		private $mappingInfo;
		private $next;

		public function __construct(SourceData $mappingInfo) {
			$this->mappingInfo = $mappingInfo;
		}

		public function generateId(Session $session, $entity) {
			//TODO This needs to be fixed, it doesn't work for anything
			if ($this->next === null) {
				$conn = $session->getPersister(get_class($entity))->getConnection();
				$primaryKeys = $this->mappingInfo->getPrimaryKeys();
				$query = sprintf('select max(%s) from %s', implode(', ', $primaryKeys), $this->mappingInfo->getSource());
				if (count($primaryKeys) > 1) {
					$query .= "\nwhere ";
					$whereClauses = array();
					$id = $entity->getId();
					foreach ($primaryKeys as $column) {
						if (!$column->isAutoIncrement) {
							$whereClauses[] = $column->name .' = ' . $id[$column->name];
						}
					}

					$query .= implode("\nAND ", $whereClauses);
				}

				$this->next = (int)$conn->prepare($query)->fetchColumn(0);
			}

			return ++$this->next;
		}

		public function requiresIdOnInsert() {
			return false;
		}
	}
	
?>