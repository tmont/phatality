<?php

	namespace Phatality\Mapping;

	class Column {
		public $name;
		public $type;
		public $size;
		public $isAutoIncrement;
		public $isPrimaryKey;
		public $constraints;
		public $foreignKeySource;
		public $foreignKeyColumn;

		public function __construct($name, $type, $size = PHP_INT_MAX, $isAutoIncrement = false, $isPrimaryKey = false, array $constraints = array(), $foreignKeySource = null, $foreignKeyColumn = null) {
			$this->name = $name;
			$this->type = $type;
			$this->size = $size;
			$this->isAutoIncrement = (bool)$isAutoIncrement;
			$this->isPrimaryKey = (bool)$isPrimaryKey;
			$this->constraints = $constraints;
			$this->foreignKeySource = $foreignKeySource;
			$this->foreignKeyColumn = $foreignKeyColumn;
		}
	}
	
?>