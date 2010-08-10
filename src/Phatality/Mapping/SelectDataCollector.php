<?php

	namespace Phatality\Mapping;
	
	class SelectDataCollector implements DataCollector {

		public function collectData(array $originalData, EntityMapping $mapping, array $constraints) {
			//run select query for the data we need, $originalData is ignored

			$alias = $mapping->getJoinAlias();

			$query = "SELECT $alias.* FROM table";
			if (!empty($constraints)) {
				foreach ($constraints as $column => $value) {
					$clauses[] = "$column = $value";
				}

				$query .= "\nWHERE " . implode("\nAND ", $clauses);
			}

			return $mapping
				->getPersister()
				->getConnection()
				->prepare($query)
				->fetchAll();
		}
	}

?>