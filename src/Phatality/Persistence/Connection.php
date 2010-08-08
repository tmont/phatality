<?php

	namespace Phatality\Persistence;

	interface Connection {
		function prepare($query);
		function isValid();
		function disconnect();
		function connect();

		/**
		 * Begins a trasaction
		 * 
		 * @return bool
		 */
		function beginTransaction();
		function commit();
		function rollback();
	}
	
?>