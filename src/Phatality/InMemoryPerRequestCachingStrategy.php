<?php

	namespace Phatality;

	class InMemoryPerRequestCachingStrategy implements Cache, CacheKeyGenerator {
		
		private static $cache = array();

		public function get($id, $type) {
			return @self::$cache[$this->generateKey($id, $type)];
		}
		
		public function set(Entity $entity) {
			self::$cache[$this->generateKeyFromEntity($entity)] = $entity;
		}
		
		public function remove($id, $type) {
			unset(self::$cache[$this->generateKey($id, $type)]);
		}
		
		public function purge() {
			self::$cache = array();
		}

		public function count() {
			return count(self::$cache);
		}

		public function generateKey($id, $type) {
			return $type . '|' . serialize($id);
		}

		public function generateKeyFromEntity($entity) {
			if ($entity instanceof Identifiable) {
				return $this->generateKey($entity->getId(), get_class($entity));
			}

			return get_class($entity) . '|' . serialize($entity);
		}
	}
	
?>