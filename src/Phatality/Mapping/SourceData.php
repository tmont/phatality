<?php

	namespace Phatality\Mapping;

	abstract class SourceData {

		
		public abstract function getPrimaryKeys();

		public function getForeignKeys() {
			return array();
		}

		public abstract function getSource();

		public abstract function getPersisterType();
		
		public abstract function getColumns();
	}
	
?>