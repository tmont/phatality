<?php

	namespace Phatality\Tests;

	use Phatality\Identifiable;

	class FakeEntity implements Identifiable {

		private $id;

		public function __construct($id) {
			$this->id = $id;
		}

		public function getId() {
			return $this->id;
		}
	}

?>