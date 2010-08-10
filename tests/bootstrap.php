<?php

	require_once 'PHPUnit/Framework.php';
	require_once 'PHPUnit/Extensions/OutputTestCase.php';
	require_once dirname(__DIR__) . '/src/Phatality/bootstrap.php';
	
	spl_autoload_register(function($class) {
		if (strpos($class, 'Phatality\Tests\\') === 0) {
			require_once __DIR__ . '/helpers.php';
		} else if (strpos($class, 'Phatality\Sample\\') === 0) {
			$file = dirname(__DIR__) . '/sample/' . str_replace('\\', '/', str_replace('Phatality\\Sample\\', '', $class)) . '.php';
			if (is_file($file)) {
				require_once $file;
			}
		}
	});

?>