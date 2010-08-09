<?php

	namespace Phatality\Cache;

	use Countable;

	interface Cache extends Countable {
		/**
		 * Gets an entity from the cache based on its id and type
		 *
		 * @param mixed $id
		 * @param string $type
		 * @return CacheEntry
		 */
		function get($id, $type);

		/**
		 * Inserts an entity into the cache
		 *
		 * @param Entity $entity
		 */
		function set(Entity $entity);

		/**
		 * Removes an entity from the cache
		 *
		 * @param mixed $id
		 * @param string $entityType
		 */
		function remove($id, $entityType);

		/**
		 * Clears the cache
		 */
		function clear();
	}
	
?>