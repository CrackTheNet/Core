<?php
	use \CTN\Auth;
	use \CTN\Session;
	use \CTN\Response;
	
	if(!Auth::isLoggedIn()) {
		Response::redirect('/login');
	}
	
	$logout_warning = false;
	
	if(!Auth::hadLoggedOut()) {
		Session::remove('security_logout');
		$logout_warning = true;
	}
		
	$scope->getTemplate()->display('user/overview', [
		'logout_warning'	=> $logout_warning
	]);
?>