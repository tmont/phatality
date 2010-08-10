<?php

	namespace Phatality\Persistence;

	use Phatality\Entity;

	interface Persister {
		/**
		 * @param Entity $entity
		 * @return Entity
		 */
		function insert(Entity $entity);
		function update(Entity $entity);

		/**
		 * Deletes an entity
		 *
		 * @param mixed $id
		 * @param string $type
		 */
		function delete($id, $type);

		/**
		 * Loads an entity based on its unique ID and object type
		 * 
		 * @param mixed $id
		 * @param string $type
		 * @return Entity The loaded entity
		 */
		function load($id, $type);
		
		function fetchAll($type);
		function insertOrUpdate(Entity $entity);
		function replace(Entity $entity);

		/**
		 * Returns an object to enable custom query building
		 * 
		 * @return Connection
		 */
		function getConnection();
	}

?>