<?php

	namespace Phatality;

	interface EntityFactory {
		function createEntity($entityType, array $args = array());
	}
	
?>