<?php

	namespace Phatality\Persistence;

	interface PersisterLocator {
		
		/**
		 * Retrieves a {@link Persister} for the specified entity type
		 * 
		 * @param string $entityType
		 * @return Persister
		 */
		function getPersister($entityType);
	}
	
?>