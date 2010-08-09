<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\SourceData;
	use Phatality\Mapping\Column;
	use Phatality\Mapping\ForeignKey;

	class UserData implements SourceData {

		private $source = 'test.users';
		private $persisterType = 'Phatality\PdoPersister';

		public function getForeignKeys() {
			return array();
		}

		public function getPrimaryKeys() {
			return array(
				new Column('user_id', 'int', PHP_INT_MAX, true, true, array('unique'))
			);
		}

		public function getSource() {
			return $this->source;
		}

		public function serialize() {

		}

		public function unserialize($serialized) {
			
		}

		public function getPersisterType() {
			return $this->persisterType;
		}

		public function getColumns() {
			return array(
				new Column('user_id', 'int', PHP_INT_MAX, true, true, array('unique')),
				new Column('username', 'string', 200, false, false, array('non-null')),
				new Column('password', 'fixed-string', 40, false, false, array('non-null')),
				new Column('first_name', 'string', 200 , false, false, array('non-null')),
				new Column('last_name', 'string', 200 , false, false, array('non-null')),
				new Column('created', 'timestamp', null , false, false, array('non-null'))
			);
		}
	}
	
?>