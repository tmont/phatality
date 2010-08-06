<?php

	spl_autoload_register(function($class) {
		$file = dirname(__DIR__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, ltrim($class, '\\')) . '.php';
		
		if (is_file($file)) {
			require_once $file;
		}
	});

	require_once dirname(dirname(__DIR__)) . '/lib/ezc/Base/src/ezc_bootstrap.php';

?>