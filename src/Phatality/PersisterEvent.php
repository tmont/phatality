<?php

	namespace Phatality;

	use Exception;

	interface PersisterEvent {
		function getReturnValue();
		function setReturnValue($returnValue);
		function getSession();
	}
	
?>