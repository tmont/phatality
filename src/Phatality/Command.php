<?php

	namespace Phatality;

	interface Command {
		function execute(CommandContext $context = null);
	}
	
?>