<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\EntityMapping;
	use Phatality\Persistence\PersisterRegistry;

	class UserEntityMapping extends EntityMapping {

		public function __construct(PersisterRegistry $persisterRegistry) {
			parent::__construct(new UserData(), $persisterRegistry);
		}

		protected function getPropertyMappings() {
			return array(
				'id' => array('column' => 'user_id', 'mapping' => 'property', 'type' => 'int'),
				'username' => array('column' => 'username', 'mapping' => 'property'),
				'password' => array('column' => 'password', 'mapping' => 'property', 'setter' => 'reflectedPrivateField'),
				'firstName' => array('column' => 'first_name', 'mapping' => 'property'),
				'lastName' => array('column' => 'last_name', 'mapping' => 'property'),
				'locale' => array('column' => 'locale', 'mapping' => 'property'),
				'created' => array('column' => 'created', 'mapping' => 'property', 'setter' => 'reflectedPrivateField'),
			);
		}

		protected function getIdGeneratorType() {
			return 'Phatality\SingleAutoIncrementIdGenerator';
		}

		public function getEntityType() {
			return 'Phatality\Sample\User';
		}

		protected function getDefaultGetterType() {
			return 'accessorMethod';
		}

		protected function getDefaultSetterType() {
			return 'accessorMethod';
		}

		public function getJoinAlias() {
			return '_user';
		}
	}
	
?>