<?php
	use \CTN\Options;
	use \CTN\Database;
	
	$rules = Database::fetch('SELECT * FROM `' . DATABASE_PREFIX . 'rules`');
	
	$scope->getTemplate()->assign('title',			'Regeln');
	$scope->getTemplate()->assign('description',	Options::get('RULES_TEXT'));
	$scope->getTemplate()->assign('rules',			$rules);
	$scope->getTemplate()->assign('count',			count($rules));
	
	$scope->getTemplate()->display('rules');
?>