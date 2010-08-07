<?php

	namespace Phatality;

	interface EventListener {
		function notify(PersisterEvent $event);
	}

?>