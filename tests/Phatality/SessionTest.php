<?php

	namespace Phatality\Tests;

	use Phatality\Session;
	use Phatality\EntityMap;

	class SessionTest extends \PHPUnit_Framework_TestCase {

		public function testLoad() {
			$cache = $this->getMock('Phatality\CachingStrategy');
			$cache->expects($this->any())->method('get')->will($this->returnValue(null));

			$entity = new FakeEntity(7);

			$persister = $this->getMock('Phatality\Persister');
			$persister
				->expects($this->once())
				->method('load')
				->with(7, 'Phatality\Tests\FakeEntity')
				->will($this->returnValue($entity));

			$session = $this->getMock('Phatality\Session', array('notifyListeners', 'getPersister'), array(new EntityMap(), $cache));
			$session
				->expects($this->once())
				->method('getPersister')
				->with('Phatality\Tests\FakeEntity')
				->will($this->returnValue($persister));

			self::assertSame($entity, $session->load(7, 'Phatality\Tests\FakeEntity'));
		}

		public function testLoadShouldUseCache() {
			$entity = new FakeEntity(7);
			
			$cache = $this->getMock('Phatality\CachingStrategy');
			$cache->expects($this->any())->method('get')->will($this->returnValue($entity));

			//the persister should never load the entity
			$session = $this->getMock('Phatality\Session', array('notifyListeners', 'getPersister'), array(new EntityMap(), $cache));
			$session->expects($this->never())->method('getPersister');

			self::assertSame($entity, $session->load(7, 'Phatality\Tests\FakeEntity'));
		}

		public function testLoadShouldFireApproriateEvents() {
			$entity = new FakeEntity(7);

			$cache = $this->getMock('Phatality\CachingStrategy');
			$cache->expects($this->any())->method('get')->will($this->returnValue(null));

			$persister = $this->getMock('Phatality\Persister');
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