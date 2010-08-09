<?php

	namespace Phatality\Mapping;

	interface SourceData extends Serializable {
		function getPrimaryKeys();
		function getForeignKeys();
		function getSource();
		function getPersisterType();
		function getColumns();
	}
	
?>