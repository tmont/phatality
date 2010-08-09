<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\EntityMapping;
	use Phatality\PersisterRegistry;

	class PostEntityMapping extends EntityMapping {

		public function __construct(PersisterRegistry $persisterRegistry) {
			parent::__construct(new PostData(), $persisterRegistry);
		}

		protected function getColumnMappings() {
			return array(
				'post_id' => array('name' => 'id', 'mapping' => 'property'),
				'user_id' => array('name' => 'user', 'mapping' => 'many-to-one', 'type' => 'Phatality\User'),
				'title' => array('name' => 'title', 'mapping' => 'property'),
				'postdata' => array('name' => 'postData', 'mapping' => 'property')
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