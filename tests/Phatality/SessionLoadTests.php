<?php

	namespace Phatality\Tests;

	use Phatality\Session;
	use Phatality\Entity;
	use Phatality\Mapping\EntityMap;
	use Phatality\Cache\CacheEntry;

	class SessionLoadTests extends \PHPUnit_Framework_TestCase {

		public function testLoadEntityAndAddToCache() {
			$entity = new FakeEntity(7);

			$cache = $this->getMock('Phatality\Cache\Cache');
			$cache->expects($this->once())->method('get')->will($this->returnValue(null));
			$methodsToMock = array('getPropertyMappings', 'getIdGeneratorType', 'getEntityType', 'getDefaultGetterType', 'getDefaultSetterType', 'getJoinAlias');
			$entityMapping = $this->getMock('Phatality\Mapping\EntityMapping', $methodsToMock, array(), '', false);
			$cache->expects($this->once())->method('set')->with(new Entity($entity, $entityMapping));

			$persister = $this->getMock('Phatality\Persistence\Persister');
			$persister
				->expects($this->once())
				->method('load')
				->with(7, 'Phatality\Tests\FakeEntity')
				->will($this->returnValue($entity));

			$session = $this->getMock('Phatality\Session', array('notifyListeners', 'getPersister'), array(new EntityMap(), $cache));
			$session->expects($this->any())->method('notifyListeners');
			$session
				->expects($this->once())
				->method('getPersister')
				->with('Phatality\Tests\FakeEntity')
				->will($this->returnValue($persister));

			self::assertSame($entity, $session->load(7, 'Phatality\Tests\FakeEntity'));
		}

		public function testLoadShouldGetFromCacheAndNotUsePersister() {
			$entity = new FakeEntity(7);

			$cache = $this->getMock('Phatality\Cache\Cache');
			$cache->expects($this->once())->method('get')->will($this->returnValue(new CacheEntry(time(), $entity)));

			//the persister should never load the entity
			$session = $this->getMock('Phatality\Session', array('notifyListeners', 'getPersister'), array(new EntityMap(), $cache));
			$session->expects($this->never())->method('getPersister');

			self::assertSame($entity, $session->load(7, 'Phatality\Tests\FakeEntity'));
		}

		public function testLoadShouldFireApproriateEvents() {
			$entity = new FakeEntity(7);

			$cache = $this->getMock('Phatality\Cache\Cache');
			$cache->expects($this->any())->method('get')->will($this->returnValue(null));

			$persister = $this->getMock('Phatality\Persistence\Persister');
			$persister
				->expects($this->any())
				->method('load')
				->will($this->returnValue($entity));

			$session = $this->getMock('Phatality\Session', array('getPersister'), array(new EntityMap(), $cache));
			$session
				->expects($this->any())
				->method('getPersister')
				->will($this->returnValue($persister));

			$beforeLoadListener = $this->getMock('Phatality\EventListener');
			$beforeLoadListener->expects($this->at(0))->method('notify')->will($this->returnCallback(function($event) {
				\PHPUnit_Framework_Assert::assertType('Phatality\LoadEvent', $event);
				\PHPUnit_Framework_Assert::assertEquals(7, $event->getEntityId());
				\PHPUnit_Framework_Assert::assertEquals('Phatality\Tests\FakeEntity', $event->getEntityType());
				\PHPUnit_Framework_Assert::assertNull($event->getReturnValue());
			}));

			$afterLoadListener = $this->getMock('Phatality\EventListener');
			$afterLoadListener->expects($this->at(0))->method('notify')->will($this->returnCallback(function($event) use ($entity) {
				\PHPUnit_Framework_Assert::assertType('Phatality\LoadEvent', $event);
				\PHPUnit_Framework_Assert::assertEquals(7, $event->getEntityId());
				\PHPUnit_Framework_Assert::assertEquals('Phatality\Tests\FakeEntity', $event->getEntityType());
				\PHPUnit_Framework_Assert::assertSame($entity, $event->getReturnValue());
			}));

			$session
				->addListener('beforeLoad', $beforeLoadListener)
				->addListener('afterLoad', $afterLoadListener);

			self::assertSame($entity, $session->load(7, 'Phatality\Tests\FakeEntity'));
		}

	}


?>