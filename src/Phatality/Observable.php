<?php

	namespace Phatality;

	interface Observable {
		function addListener($eventName, EventListener $listener);
		function getListeners($eventName = null);
	}

?>