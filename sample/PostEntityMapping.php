<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\EntityMapping;
	use Phatality\Mapping\PropertyMapperFactory;
	use Phatality\Persistence\PersisterRegistry;

	class PostEntityMapping extends EntityMapping {

		public function __construct(PersisterRegistry $persisterRegistry, PropertyMapperFactory $mapperFactory = null) {
			parent::__construct(new PostData(), $persisterRegistry, $mapperFactory);
		}

		protected function getPropertyMappings() {
			return array(
				'id' => array('column' => 'post_id', 'mapping' => 'property', 'type' => 'int'),
				'user' => array('column' => 'user_id', 'mapping' => 'many-to-one', 'type' => 'Phatality\Sample\User'),
				'title' => array('column' => 'title', 'mapping' => 'property'),
				'postData' => array('column' => 'postdata', 'mapping' => 'property'),
				'comments' => array('mapping' => 'collection', 'type' => 'Phatality\Sample\Comment', 'table' => 'comments', 'column' => 'post_id', 'key' => 'post_id')
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