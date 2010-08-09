<?php

	namespace Phatality\Sample;

	use Phatality\Mapping\SourceData;
	use Phatality\Mapping\Column;
	use Phatality\Mapping\ForeignKey;

	class PostData extends SourceData {

		public function getForeignKeys() {
			return array(
				new ForeignKey($this->getSource(), 'user_id', 'test.users', 'user_id')
			);
		}

		public function getPrimaryKeys() {
			return array(
				new Column('post_id', 'int', PHP_INT_MAX, true, true, array('unique'))
			);
		}

		public function getSource() {
			return 'test.posts';
		}

		public function getPersisterType() {
			return 'Phatality\PdoPersister';
		}

		public function getColumns() {
			return array(
				new Column('post_id', 'int', PHP_INT_MAX, true, true, array('unique')),
				new Column('user_id', 'int', PHP_INT_MAX, false, false, array(), 'test.users', 'user_id'),
				new Column('title', 'string', 200, false, false, array('non-null')),
				new Column('postdata', 'string', 51200 /*50KB*/, false, false, array('non-null'))
			);
		}
	}
	
?>