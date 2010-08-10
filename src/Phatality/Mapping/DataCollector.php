<?php

	namespace Phatality\Mapping;
	
	interface DataCollector {
		function collectData(array $originalData, EntityMapping $mapping,array $constraints);
	}

?>