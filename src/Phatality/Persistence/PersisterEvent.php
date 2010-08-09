<?php

	namespace Phatality\Persistence;

	interface PersisterEvent {
		function getReturnValue();
		function setReturnValue($returnValue);
		function getSession();
	}
	
?>