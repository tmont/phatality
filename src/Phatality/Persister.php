<?php

	namespace Phatality;

	interface Persister {
		function insert(Entity $entity);
		function update(Entity $entity);
		function delete(Entity $entity);

		/**
		 * Loads an entity into the session based on its unique ID and object type
		 * 
		 * @param mixed $id
		 * @param string $type
		 * @return Entity The loaded entity
		 */
		function load($id, $type);
		
		function fetchAll($id, $type);
		function insertOrUpdate(Entity $entity);
		function replace(Entity $entity);
	}

?>