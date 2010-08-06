<?php

	namespace Phatality;

	interface EventListener {
		function notify(Observable $subject);
	}

?>