<?php

	namespace Phatality\Mapping;

	class ForeignKey {
		public $source;
		public $sourceColumn;
		public $foreign;
		public $foreignColumn;

		public function __construct($source, $sourceColumn, $foreign, $foreignColumn) {
			$this->source = $source;
			$this->sourceColumn = $sourceColumn;
			$this->foreignColumn = $foreignColumn;
			$this->foreign = $foreign;
		}
	}
	
?>