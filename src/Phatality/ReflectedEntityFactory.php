<?php

	namespace Phatality;

	class ReflectedEntityFactory implements EntityFactory {

		public function createEntity($entityType, array $args = array()) {
			$class = ReflectionCache::getClass($entityType);
			return $class->newInstanceArgs($args);
		}
	}
	
?>