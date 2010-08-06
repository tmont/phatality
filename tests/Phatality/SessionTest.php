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

	}
	
?>