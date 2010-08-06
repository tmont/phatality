<?php

	namespace Phatality;

	use OutOfBoundsException, InvalidArgumentException, ArrayAccess, Countable, Iterator, Closure, Traversable, ArrayIterator;

	class Collection implements ArrayAccess, Countable, Iterator {

		private $validator;
		private $data = array();
		private $index = 0;

		public function __construct(Closure $validator = null, array $initialData = array()) {
			$this->validator = $validator ?: function($value) { return true; };
			if (!empty($initialData)) {
				$this->merge(new ArrayIterator($initialData));
			}
		}

		public function merge(Traversable $data) {
			foreach ($data as $key => $value) {
				$this[$key] = $value;
			}
		}

		public function clear() {
			$this->data = array();
			$this->index = 0;
		}

		public function toArray() {
			return $this->data;
		}

		public function contains($value) {
			return in_array($value, $this->data);
		}

		public function containsKey($key) {
			return $this->offsetExists($key);
		}

		public function filter(Closure $function) {
			$values = array();
			foreach ($this->data as $key => $value) {
				if ($function($key, $value)) {
					$values[$key] = $value;
				}
			}

			return $values;
		}

		protected function valueIsValid($value) {
			return is_callable($this->validator) && call_user_func($this->validator, $value);
		}

		public function prepend($value) {
			$this->verify($value);
			array_unshift($this->data, $value);
		}

		public function append($value) {
			$this->verify($value);
			$this->data[] = $value;
		}

		public function offsetExists($key) {
			return array_key_exists($key, $this->data);
		}

		public function offsetGet($key) {
			return $this->get($key);
		}

		protected final function verify($value) {
			if (!$this->valueIsValid($value)) {
				throw new InvalidArgumentException('This collection does not allow values of type ' . (is_object($value) ? get_class($value) : gettype($value)));
			}
		}

		protected final function set($key, $value) {
			$this->data[$key] = $value;
		}

		protected final function get($key) {
			return @$this->data[$key];
		}

		public function tryGet($key, &$value) {
			if (!$this->offsetExists($key)) {
				$value = null;
				return false;
			}

			$value = $this->get($key);
			return true;
		}

		public function offsetSet($key, $value) {
			$this->verify($value);
			$this->set($key, $value);
		}

		public function offsetUnset($key) {
			unset($this->data[$key]);
		}

		public function count() {
			return count($this->data);
		}

		public function current() {
			return current($this->data);
		}

		public function next() {
			$this->index++;
			return next($this->data);
		}

		public function rewind() {
			reset($this->data);
			$this->index = 0;
		}

		public function key() {
			return key($this->data);
		}

		public function valid() {
			return $this->index < count($this);
		}

		public function __toString() {
			return var_export($this->data, true);
		}

	}

?>