<?php

	namespace Phatality\Mapping;

	use Serializable, ArrayIterator;
	use Phatality\Collection;

	class EntityMap extends Collection implements Serializable {

		protected function valueIsValid($value) {
			return $value instanceof EntityMapping;
		}

		public function serialize() {
			return serialize($this->toArray());
		}

		public function unserialize($serialized) {
			$this->merge(new ArrayIterator(unserialize($serialized)));
		}

		public function offsetGet($entityType) {
			$value = $this->get($entityType);
			if ($value === null) {
				throw new MappingException(sprintf('The type "%s" is not mapped'));
			}

			return $value;
		}

	}
	
?>