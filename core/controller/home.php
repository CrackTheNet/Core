<?php
	use \CTN\Auth;
	use \CTN\Response;
	
	if(Auth::isLoggedIn()) {
		Response::redirect('/overview');
	}
	
	$scope->getTemplate()->display('home');
?>