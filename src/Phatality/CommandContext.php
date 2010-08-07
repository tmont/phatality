<?php

	namespace Phatality;

	interface CommandContext {

		/**
		 * Indicates whether the next command should be executed
		 * 
		 * @return bool
		 */
		function shouldProceed();

		/**
		 * Cancels the current command sequence
		 */
		function cancel();

	}
	
?>