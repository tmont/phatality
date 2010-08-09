<?php

	namespace Phatality\Persistence;

	use Serializable;
	use Phatality\Config;

	class PersisterRegistry implements Serializable {

		private static $registry = array();
		private $config;

		public function __construct(Config $config) {
			$this->config = $config;
		}

		/**
		 * @param string $persisterType
		 * @return Persister
		 */
		public function getOrCreatePersister($persisterType) {
			return @self::$registry[$persisterType] ?: $this->createPersister($persisterType);
		}

		/**
		 * @param string $persisterType
		 * @return Persister
		 */
		private function createPersister($persisterType) {
			self::$registry[$persisterType] = new $persisterType($this->config->getSection('persisters')->getValue($persisterType));
			return self::$registry[$persisterType];
		}

		public function serialize() {
			return serialize($this->config);
		}

		public function unserialize($serialized) {
			$this->config = unserialize($serialized);
		}
	}
	
?>