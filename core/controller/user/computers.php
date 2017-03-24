<?php
	use \CTN\Auth;
	use \CTN\Response;
	
	if(!Auth::isLoggedIn()) {
		Response::redirect('/login');
	}
	
	$scope->getTemplate()->display('user/computers');
?>