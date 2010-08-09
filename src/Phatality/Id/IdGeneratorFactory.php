<?php

	namespace Phatality\Id;

	interface IdGeneratorFactory {

		/**
		 * @return IdGenerator
		 */
		function getIdGenerator();
	}
	
?>