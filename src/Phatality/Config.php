<?php

	namespace Phatality;

	use ArrayAccess, Serializable;

	class Config implements ArrayAccess, Serializable {

		private $data;

		public function __construct(array $data) {
			$this->data = $data;
		}

		public function offsetExists($offset) {
			return array_key_exists($offset, $this->data);
		}

		public function offsetGet($offset) {
			return @$this->data[$offset];
		}

		public function offsetSet($offset, $value) {
			$this->data[$offset] = $value;
		}

		public function offsetUnset($offset) {
			unset($this->data[$offset]);
		}

		public function getSection($name) {
			return is_array(@$this->data[$name]) ? new self($this->data[$name]) : null;
		}

		public function getValue($key) {
			return $this[$key];
		}

		public function serialize() {
			return serialize($this->data);
		}

		public function unserialize($serialized) {
			$this->data = unserialize($serialized);
		}
	}
	
?>