<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\EntityMapping;
	use Phatality\Persistence\PersisterRegistry;

	class UserEntityMapping extends EntityMapping {

		public function __construct(PersisterRegistry $persisterRegistry) {
			parent::__construct(new UserData(), $persisterRegistry);
		}

		protected function getColumnMappings() {
			return array(
				'user_id' => array('name' => 'id', 'mapping' => 'property', 'type' => 'int'),
				'username' => array('name' => 'username', 'mapping' => 'property'),
				'password' => array('name' => 'password', 'mapping' => 'property'),
				'first_name' => array('name' => 'firstName', 'mapping' => 'property'),
				'last_name' => array('name' => 'lastName', 'mapping' => 'property'),
				'locale' => array('name' => 'locale', 'mapping' => 'property'),
				'created' => array('name' => 'created', 'mapping' => 'property'),
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