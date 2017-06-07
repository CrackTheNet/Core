<?php
	use \CTN\Auth;
	use \CTN\Session;
	use \CTN\Response;
	
	if(!Auth::isLoggedIn()) {
		Response::redirect('/login');
	}
	
	if(!Auth::isAdmin()) {
		$scope->getTemplate()->display('403');
		return;
	}
	
	$scope->getTemplate()->display('admin/plugins');
?>