<?php

	namespace Phatality\Cache;

	class CacheEntry {
		
		/**
		 * @var int
		 */
		private $timestamp;
		
		/**
		 * @var object
		 */
		private $value;

		public function __construct($timestamp, $value) {
			$this->timestamp = $timestamp;
			$this->value = $value;
		}

		/**
		 * Gets the time (Unix timestamp) at which the value was inserted into the cache
		 *
		 * @return int
		 */
		public function getTimestamp() {
			return $this->timestamp;
		}

		/**
		 * @return object
		 */
		public function getValue() {
			return $this->value;
		}

	}
	
?>