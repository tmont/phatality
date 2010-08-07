<?php

	namespace Phatality;

	interface CacheKeyGenerator {

		/**
		 * Generates a unique key from the given id and entity type
		 * @param mixed $id
		 * @param string $type
		 * @return vostringid
		 */
		function generateKey($id, $type);
	}
	
?>