<?php

	namespace Phatality\Tests;

	use Phatality\Sample\PostEntityMapping;
	use Phatality\Sample\UserEntityMapping;
	use Phatality\Sample\Post;
	use Phatality\Persistence\PersisterRegistry;
	use Phatality\Config;
	use Phatality\Mapping\EntityMap;

	class MappingTests extends \PHPUnit_Framework_TestCase {

		

		public function testMappingProperties() {
			$persisterRegistry = new PersisterRegistry(new Config(array()));
			$mapping = new PostEntityMapping($persisterRegistry);

			$object = new Post();
			$dataFromDb = array(
				'_this.post_id' => '1',
				'_this.title' => 'This is the title',
				'_this.postdata' => 'This is the post'
			);

			$entityMap = new EntityMap();

			$entity = $mapping->loadEntity($object, $dataFromDb, $entityMap);

			self::assertSame($entity, $object);

			self::assertSame(1, $object->getId());
			self::assertEquals('This is the title', $object->getTitle());
			self::assertEquals('This is the post', $object->getPostData());
		}

		public function testMappingManyToOne() {
			$persisterRegistry = new PersisterRegistry(new Config(array()));
			$mapping = new PostEntityMapping($persisterRegistry);

			$object = new Post();
			$dataFromDb = array(
				'_this.user_id' => '3',
				'_user.username' => 'foo'

			);

			$entityMap = new EntityMap(null, array(
				'Phatality\Sample\User' => new UserEntityMapping($persisterRegistry)
			));

			$entity = $mapping->loadEntity($object, $dataFromDb, $entityMap);

			self::assertSame($entity, $object);
			self::assertType('Phatality\Sample\User', $object->getUser());
			self::assertSame('foo', $object->getUser()->getUsername());
			self::assertSame(3, $object->getUser()->getId());
		}

	}

?>