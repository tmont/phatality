<?php

	namespace Phatality;

	use Countable;

	interface CachingStrategy extends Countable {
		function get($id, $type);
		function set(Entity $entity);
		function remove($id, $type);
		function purge();
	}
	
?>