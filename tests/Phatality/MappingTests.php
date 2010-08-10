<?php

	namespace Phatality\Tests;

	use Phatality\Sample\User;
	use Phatality\Sample\Post;
	use Phatality\Sample\PostEntityMapping;
	use Phatality\Mapping\MapperType;
	use Phatality\Persistence\PersisterRegistry;
	use Phatality\Config;
	use Phatality\Mapping\EntityMap;
	use Phatality\Mapping\DirectValueMapper;
	use Phatality\Mapping\ManyToOneMapper;

	class MappingTests extends \PHPUnit_Framework_TestCase {

		public function testMappingProperties() {
			$entity = new Post();
			$dataFromDb = array(
				'_this.post_id' => '1',
				'_this.title' => 'This is the title',
				'_this.postdata' => 'This is the post'
			);

			$directValueMapper = $this->getMock('Phatality\Mapping\PropertyMapper');
			$directValueMapper->expects($this->at(0))->method('map')->with('id', '1', 'int');
			$directValueMapper->expects($this->at(1))->method('map')->with('title', 'This is the title', 'string');
			$directValueMapper->expects($this->at(2))->method('map')->with('postData', 'This is the post', 'string');

			$mapperFactory = $this->getMock('Phatality\Mapping\PropertyMapperFactory');
			$mapperFactory->expects($this->at(0))->method('getPropertyMapper')->with(MapperType::Property)->will($this->returnValue($directValueMapper));

			$persisterRegistry = new PersisterRegistry(new Config(array()));
			$mapping = new PostEntityMapping($persisterRegistry, $mapperFactory);

			$entityMap = new EntityMap();
			$returnedEntity = $mapping->loadEntity($entity, $dataFromDb, $entityMap);

			self::assertSame($entity, $returnedEntity);
		}

		public function testDirectValueMapper() {
			$entity = new Post();

			$setter = $this->getMock('Phatality\Mapping\PropertySetter');
			$setter->expects($this->once())->method('set')->with($entity, 'id', new \PHPUnit_Framework_Constraint_IsIdentical(5));

			$mapper = new DirectValueMapper($entity);
			$mapper->map('id', '5', 'int', $setter, array());
		}

		public function testManyToOneMapper() {
			$entity = new Post();

			$dataFromDb = array(
				'_this.user_id' => '3',
				'_user.username' => 'foo'
			);

			$setter = $this->getMock('Phatality\Mapping\PropertySetter');
			$setter
				->expects($this->once())
				->method('set')
				->with($entity, 'user', new \PHPUnit_Framework_Constraint_IsInstanceOf('Phatality\Sample\User'));

			$persisterRegistry = new PersisterRegistry(new Config(array()));
			$userMapping = $this->getMock('Phatality\Sample\UserEntityMapping', array('loadEntity'), array($persisterRegistry));
			$entityMap = new EntityMap(array('Phatality\Sample\User' => $userMapping));

			$userMapping
				->expects($this->once())
				->method('loadEntity')
				->with(
					new \PHPUnit_Framework_Constraint_IsInstanceOf('Phatality\Sample\User'),
					array('_this.username' => 'foo', '_this.user_id' => '3'),
					$entityMap
				)->will($this->returnValue(new User()));

			$mapper = new ManyToOneMapper($entity, $entityMap);
			$mapper->map('user', '3', 'Phatality\Sample\User', $setter, $dataFromDb);
		}

		public function testManyToOneMapperWithoutPrimaryKey() {
			$entity = new Post();
			$dataFromDb = array(
				'_this.user_id' => '3',
				'_user.username' => 'foo'
			);

			$setter = $this->getMock('Phatality\Mapping\PropertySetter');
			$setter->expects($this->never())->method('set');

			$sourceData = $this->getMock('Phatality\Mapping\SourceData');
			$sourceData->expects($this->once())->method('getPrimaryKeys')->will($this->returnValue(array()));

			$persisterRegistry = new PersisterRegistry(new Config(array()));
			$userMapping = $this->getMock('Phatality\Sample\UserEntityMapping', array('loadEntity', 'getSourceData'), array($persisterRegistry));

			$userMapping->expects($this->never())->method('loadEntity');
			$userMapping->expects($this->once())->method('getSourceData')->will($this->returnValue($sourceData));

			$entityMap = new EntityMap(array('Phatality\Sample\User' => $userMapping));

			$errorMessage =
				'Invalid primary key for entity "Phatality\Sample\User": cannot establish many-to-one relationship with ' .
				'entity "Phatality\Sample\Post" because a suitable key was not found';
			
			$this->setExpectedException('Phatality\Mapping\MappingException', $errorMessage);
			$mapper = new ManyToOneMapper($entity, $entityMap);
			$mapper->map('user', '3', 'Phatality\Sample\User', $setter, $dataFromDb);
		}

		public function testManyToOneMapperWithCompositePrimaryKey() {
			$entity = new Post();
			$dataFromDb = array(
				'_this.user_id' => '3',
				'_user.username' => 'foo'
			);

			$setter = $this->getMock('Phatality\Mapping\PropertySetter');
			$setter->expects($this->never())->method('set');

			$sourceData = $this->getMock('Phatality\Mapping\SourceData');
			$sourceData->expects($this->once())->method('getPrimaryKeys')->will($this->returnValue(array('foo', 'bar')));

			$persisterRegistry = new PersisterRegistry(new Config(array()));
			$userMapping = $this->getMock('Phatality\Sample\UserEntityMapping', array('loadEntity', 'getSourceData'), array($persisterRegistry));

			$userMapping->expects($this->never())->method('loadEntity');
			$userMapping->expects($this->once())->method('getSourceData')->will($this->returnValue($sourceData));

			$entityMap = new EntityMap(array('Phatality\Sample\User' => $userMapping));

			$errorMessage =
				'Invalid primary key for entity "Phatality\Sample\User": cannot establish many-to-one relationship with ' .
				'entity "Phatality\Sample\Post" because a suitable key was not found';

			$this->setExpectedException('Phatality\Mapping\MappingException', $errorMessage);
			$mapper = new ManyToOneMapper($entity, $entityMap);
			$mapper->map('user', '3', 'Phatality\Sample\User', $setter, $dataFromDb);
		}

		public function testMappingManyToOne() {
			$entity = new Post();
			$dataFromDb = array(
				'_this.user_id' => '1',
			);

			$manyToOneMapper = $this->getMock('Phatality\Mapping\PropertyMapper');
			$manyToOneMapper->expects($this->once())->method('map')->with('user', '1', 'Phatality\Sample\User');

			$mapperFactory = $this->getMock('Phatality\Mapping\PropertyMapperFactory');
			$mapperFactory->expects($this->at(1))->method('getPropertyMapper')->with(MapperType::ManyToOne)->will($this->returnValue($manyToOneMapper));

			$persisterRegistry = new PersisterRegistry(new Config(array()));
			$mapping = new PostEntityMapping($persisterRegistry, $mapperFactory);

			$entityMap = new EntityMap();
			$returnedEntity = $mapping->loadEntity($entity, $dataFromDb, $entityMap);

			self::assertSame($entity, $returnedEntity);
		}

	}

?>