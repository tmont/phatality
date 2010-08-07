<?php

	namespace Phatality\Tests;

	use Phatality\Session;
	use Phatality\EntityMap;

	class SessionCacheRemovalTests extends \PHPUnit_Framework_TestCase {

		public function testPurge() {
			$cache = $this->getMock('Phatality\Cache');
			$cache->expects($this->once())->method('clear');

			$session = new Session(new EntityMap(), $cache);
			$session->purge();
		}

		public function testEvict() {
			$cache = $this->getMock('Phatality\Cache');
			$cache->expects($this->once())->method('remove')->with(1, 'Phatality\Tests\FakeEntity');

			$session = new Session(new EntityMap(), $cache);
			$session->evict(1, 'Phatality\Tests\FakeEntity');
		}

	}
	
?>