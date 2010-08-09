<?php

	namespace Phatality\Tests;

	use Phatality\Mapping\PropertyGetter;
	use Phatality\Mapping\PropertySetter;
	use Phatality\Mapping\MagicMethodPropertyGetter;
	use Phatality\Mapping\MagicMethodPropertySetter;
	use Phatality\Mapping\PublicFieldPropertyGetter;
	use Phatality\Mapping\PublicFieldPropertySetter;
	use Phatality\Mapping\AccessorMethodPropertyGetter;
	use Phatality\Mapping\AccessorMethodPropertySetter;
	use Phatality\Mapping\PrivateReflectedFieldPropertyGetter;
	use Phatality\Mapping\PrivateReflectedFieldPropertySetter;

	class PropertyAccessorTests extends \PHPUnit_Framework_TestCase {

		private function verify(PropertyGetter $getter, PropertySetter $setter, $object) {
			$setter->set($object, 'foo', 'bar');
			self::assertEquals('bar', $getter->get($object, 'foo'));
		}

		public function testMagicMethodAccessors() {
			$this->verify(new MagicMethodPropertyGetter(), new MagicMethodPropertySetter(), new MagicEntity());
		}

		public function testPublicFieldAccessors() {
			$this->verify(new PublicFieldPropertyGetter(), new PublicFieldPropertySetter(), new PublicEntity());
		}

		public function testAccessorMethodAccessors() {
			$this->verify(new AccessorMethodPropertyGetter(), new AccessorMethodPropertySetter(), new AccessorEntity());
		}

		public function testPrivateReflectedFieldAccessors() {
			$this->verify(new PrivateReflectedFieldPropertyGetter(), new PrivateReflectedFieldPropertySetter(), new PrivateEntity());
		}

	}

	class MagicEntity {
		private $foo;

		public function __get($key) {
			return $this->$key;
		}

		public function __set($key, $value) {
			$this->$key = $value;
		}
	}

	class PublicEntity {
		public $foo;
	}

	class PrivateEntity {
		private $foo;
	}

	class AccessorEntity {
		private $foo;

		public function getFoo() {
			return $this->foo;
		}

		public function setFoo($foo) {
			$this->foo = $foo;
		}
	}
	
?>