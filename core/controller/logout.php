<?php
	use \CTN\Auth;
	use \CTN\Response;
	
	if(Auth::isLoggedIn()) {
		Auth::logout();
	}

	Response::redirect('/login');
?>