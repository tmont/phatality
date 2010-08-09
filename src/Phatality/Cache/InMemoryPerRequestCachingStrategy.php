<?php

	namespace Phatality\Cache;

	class InMemoryPerRequestCachingStrategy implements Cache, CacheKeyGenerator {
		
		private static $cache = array();

		public function get($id, $type) {
			return @self::$cache[$this->generateKey($id, $type)];
		}
		
		public function set(Entity $entity) {
			self::$cache[$this->generateKey($entity->getId(), $entity->getType())] = new CacheEntry(time(), $entity->getObject());
		}
		
		public function remove($id, $type) {
			unset(self::$cache[$this->generateKey($id, $type)]);
		}
		
		public function clear() {
			self::$cache = array();
		}

		public function count() {
			return count(self::$cache);
		}

		public function generateKey($id, $type) {
			return $type . '|' . serialize($id);
		}

	}
	
?>