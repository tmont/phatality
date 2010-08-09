<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\EntityMapping;
	use Phatality\PersisterRegistry;

	class UserEntityMapping extends EntityMapping {

		public function __construct(PersisterRegistry $persisterRegistry) {
			parent::__construct(new UserData(), $persisterRegistry);
		}

		protected function getColumnMappings() {
			return array(
				'user_id' => array('name' => 'id', 'mapping' => 'property'),
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
			return 'Phatality\Post';
		}
	}
	
?>