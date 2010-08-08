<?php

	namespace Phatality\Persistence;

	interface Statement {

		/**
		 * @param array $parameters
		 * @return bool
		 */
		function execute(array $parameters = array());
		function fetchNextRow();
		function fetchNextRowInto($type);
		function fetchRowAt($index);
		function fetchColumn($indexOrColumnNAme);
		function fetchAll();

	}
	
?>