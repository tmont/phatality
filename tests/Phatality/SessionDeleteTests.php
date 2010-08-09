<?php

	namespace Phatality\Tests;

	use Phatality\Session;
	use Phatality\Mapping\EntityMap;
	use Phatality\Entity;
	use Phatality\Cache\CacheEntry;

	class SessionDeleteTests extends \PHPUnit_Framework_TestCase {

		public function testDeleteEntityAndRemoveFromCache() {
			$cache = $this->getMock('Phatality\Cache\Cache');
			$cache->expects($this->once())->method('remove')->with(7, 'Phatality\Tests\FakeEntity');

			$persister = $this->getMock('Phatality\Persistence\Persister');
			$persister
				->expects($this->once())
				->method('delete')
				->with(7, 'Phatality\Tests\FakeEntity');

			$session = $this->getMock('Phatality\Session', array('notifyListeners', 'getPersister'), array(new EntityMap(), $cache));
			$session->expects($this->any())->method('notifyListeners');
			$session
				->expects($this->once())
				->method('getPersister')
				->with('Phatality\Tests\FakeEntity')
				->will($this->returnValue($persister));

			$session->delete(7, 'Phatality\Tests\FakeEntity');
		}

		public function testDeleteShouldFireApproriateEvents() {
			$cache = $this->getMock('Phatality\Cache\Cache');

			$persister = $this->getMock('Phatality\Persistence\Persister');

			$session = $this->getMock('Phatality\Session', array('getPersister'), array(new EntityMap(), $cache));
			$session
				->expects($this->any())
				->method('getPersister')
				->will($this->returnValue($persister));

			$beforeDeleteListener = $this->getMock('Phatality\EventListener');
			$beforeDeleteListener->expects($this->at(0))->method('notify')->will($this->returnCallback(function($event) {
				\PHPUnit_Framework_Assert::assertType('Phatality\DeleteEvent', $event);
				\PHPUnit_Framework_Assert::assertEquals(7, $event->getEntityId());
				\PHPUnit_Framework_Assert::assertEquals('Phatality\Tests\FakeEntity', $event->getEntityType());
			}));

			$afterDeleteListener = $this->getMock('Phatality\EventListener');
			$afterDeleteListener->expects($this->at(0))->method('notify')->will($this->returnCallback(function($event) {
				\PHPUnit_Framework_Assert::assertType('Phatality\DeleteEvent', $event);
				\PHPUnit_Framework_Assert::assertEquals(7, $event->getEntityId());
				\PHPUnit_Framework_Assert::assertEquals('Phatality\Tests\FakeEntity', $event->getEntityType());
			}));

			$session
				->addListener('beforeDelete', $beforeDeleteListener)
				->addListener('afterDelete', $afterDeleteListener);

			$session->delete(7, 'Phatality\Tests\FakeEntity');
		}

	}


?>