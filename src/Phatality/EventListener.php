<?php

	namespace Phatality;

	use Phatality\Persistence\PersisterEvent;

	interface EventListener {
		function notify(PersisterEvent $event);
	}

?>