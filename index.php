<?php
	define('VERSION',	'1.0.0');
	define('PATH',		dirname(__FILE__));
	define('DS',		DIRECTORY_SEPARATOR);
	
	require_once(sprintf('%s/core/classes/core.class.php', PATH));
	new \CTN\Core();
?>