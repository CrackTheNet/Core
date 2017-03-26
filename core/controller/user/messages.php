<?php
	use \CTN\Auth;
	use \CTN\Response;
	
	if(!Auth::isLoggedIn()) {
		Response::redirect('/login');
	}
	
	if(empty($type)) {
		$type = 'inbox';
	}
	
	$scope->getTemplate()->display('user/messages', [
		'type' => $type
	]);
?>