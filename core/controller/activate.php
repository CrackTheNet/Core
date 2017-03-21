<?php
	use \CTN\Auth;
	use \CTN\Response;
	
	if(Auth::isLoggedIn()) {
		Response::redirect('/overview');
	}

	// Check $token
	//print $token;

	$scope->getTemplate()->display('home', [
		'activated' => true
	]);
?>