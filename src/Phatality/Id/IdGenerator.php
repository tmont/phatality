<?php

	namespace Phatality;

	interface IdGenerator {

		/**
		 * Generates an ID for an entity
		 *
		 * @param Session $session
		 * @param Identifiable $entity
		 * @return mixed
		 */
		function generateId(Session $session, Identifiable $entity);

		/**
		 * @return bool
		 */
		function requiresIdOnInsert();

	}
	
?>