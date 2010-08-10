<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\EntityMapping;
	use Phatality\Persistence\PersisterRegistry;

	class PostEntityMapping extends EntityMapping {

		public function __construct(PersisterRegistry $persisterRegistry) {
			parent::__construct(new PostData(), $persisterRegistry);
		}

		protected function getColumnMappings() {
			return array(
				'post_id' => array('name' => 'id', 'mapping' => 'property', 'type' => 'int'),
				'user_id' => array('name' => 'user', 'mapping' => 'many-to-one', 'type' => 'Phatality\Sample\User'),
				'title' => array('name' => 'title', 'mapping' => 'property'),
				'postdata' => array('name' => 'postData', 'mapping' => 'property')
			);
		}

		protected function getIdGeneratorType() {
			return 'Phatality\SingleAutoIncrementIdGenerator';
		}

		public function getEntityType() {
			return 'Phatality\Sample\Post';
		}

		public function getDefaultGetterType() {
			return 'accessorMethod';
		}

		public function getDefaultSetterType() {
			return 'accessorMethod';
		}

		public function getJoinAlias() {
			return '_post';
		}
	}
	
?>