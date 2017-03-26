<?php
	use \CTN\GitHub;
	
	$scope->getTemplate()->display('system/commits', [
		'commits' => GitHub::getCommits()
	]);
?>