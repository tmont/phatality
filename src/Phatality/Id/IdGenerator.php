<?php

	namespace Phatality\Id;

	interface IdGenerator {

		/**
		 * Generates an ID for an entity
		 *
		 * @param Session $session
		 * @param object $entity
		 * @return mixed
		 */
		function generateId(Session $session, $entity);

		/**
		 * @return bool
		 */
		function requiresIdOnInsert();

	}
	
?>