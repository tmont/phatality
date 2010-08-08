<?php

	namespace Phatality;


	class Column {
		public $name;
		public $type;
		public $size;
		public $isAutoIncrement;
		public $isPrimaryKey;
		public $constraints;
		public $foreignKeyTable;
		public $foreignKeyColumn;

		public function __construct($name, $type, $size = PHP_INT_MAX, $isAutoIncrement = false, $isPrimaryKey = false, array $constraints = array(), $foreignKeyTable = null, $foreignKeyColumn = null) {
			$this->name = $name;
			$this->type = $type;
			$this->size = $size;
			$this->isAutoIncrement = (bool)$isAutoIncrement;
			$this->isPrimaryKey = (bool)$isPrimaryKey;
			$this->constraints = $constraints;
			$this->foreignKeyTable = $foreignKeyTable;
			$this->foreignKeyColumn = $foreignKeyColumn;
		}
	}

	class ForeignKey {
		public $sourceTable;
		public $sourceColumn;
		public $foreignTable;
		public $foreignColumn;

		public function __construct($sourceTable, $sourceColumn, $foreignTable, $foreignColumn) {
			$this->sourceTable = $sourceTable;
			$this->sourceColumn = $sourceColumn;
			$this->foreignColumn = $foreignColumn;
			$this->foreignTable = $foreignTable;
		}
	}
	

	class MappingInfo implements Serializable {

		private $table;
		private $columns = array();
		private $primaryKeys = array();
		private $foreignKeys = array();
		private $constraints = array();

		public function __construct($table, array $columnData) {
			$this->table = $table;
			$this->columns = $columnData;
			
			foreach ($columnData as $column) {
				if ($column->isPrimaryKey) {
					$this->primaryKeys[] = $column;	
				}
				if ($column->foreignKeyTable !== null && $column->foreignKeyColumn !== null) {
					$this->foreignKeys[] = new ForeignKey($this->table, $column->name, $column->foreignKeyTable, $column->foreignKeyColumn);
				}
				if (!empty($column->constraints)) {
					$this->constraints[$column->name] = $column->constraints;
				}
			}
		}

		public function getPrimaryKeys() {
			return $this->primaryKeys;
		}

		public function getConstraints() {
			return $this->constraints;
		}

		public function getForeignKeys() {
			return $this->foreignKeys;
		}

		public function getColumns() {
			return $this->columns;
		}

		public function getTable() {
			return $this->table;
		}

		public function serialize() {
			return serialize(
				array(
					'primaryKeys' => $this->primaryKeys,
					'constraints' => $this->constraints,
					'foreignKeys' => $this->foreignKeys,
					'columns' => $this->columns,
					'table' => $this->table
				)
			);
		}

		public function unserialize($serialized) {
			$data = unserialize($serialized);
			$this->primaryKeys = $data['primaryKeys'];
			$this->constraints = $data['constraints'];
			$this->foreignKeys = $data['foreignKeys'];
			$this->columns = $data['columns'];
			$this->table = $data['table'];
		}
	}
	
?>