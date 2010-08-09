<?php

	namespace Phatality\Mapping;

	use InvalidArgumentException;

	class PropertyAccessorFactory {

		private static $getterRegistry = array();
		private static $setterRegistry = array();

		public function getGetter($type) {
			if (!isset(self::$getterRegistry[$type])) {
				switch ($type) {
					case 'accessorMethod':
						self::$getterRegistry[$type] = new AccessorMethodPropertyGetter();
						break;
					case 'privateReflectedField':
						self::$getterRegistry[$type] = new PrivateReflectedFieldPropertyGetter();
						break;
					case 'publicField':
						self::$getterRegistry[$type] = new PublicFieldPropertyGetter();
						break;
					case 'magicMethod':
						self::$getterRegistry[$type] = new MagicMethodPropertyGetter();
						break;
					default:
						throw new InvalidArgumentException('Unknown property getter type: ' . $type);
				}

				return self::$getterRegistry[$type];
			}
		}

		public function getSetter($type) {
			if (!isset(self::$setterRegistry[$type])) {
				switch ($type) {
					case 'accessorMethod':
						self::$setterRegistry[$type] = new AccessorMethodPropertySetter();
						break;
					case 'privateReflectedField':
						self::$setterRegistry[$type] = new PrivateReflectedFieldPropertySetter();
						break;
					case 'publicField':
						self::$setterRegistry[$type] = new PublicFieldPropertySetter();
						break;
					case 'magicMethod':
						self::$setterRegistry[$type] = new MagicMethodPropertySetter();
						break;
					default:
						throw new InvalidArgumentException('Unknown property setter type: ' . $type);
				}
			}

			return self::$setterRegistry[$type];
		}

	}

	?>