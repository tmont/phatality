<?php

	namespace Phatality;

	use Countable;

	interface Cache extends Countable {
		function get($id, $type);
		function set(Entity $entity);
		function remove($id, $type);
		function purge();
	}
	
?>