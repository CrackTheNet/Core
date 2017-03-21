<?php
	use \CTN\Auth;
	use \CTN\Response;
	
	if(Auth::isLoggedIn()) {
		Response::redirect('/overview');
	}

	$errors = [];

	if(isset($_POST['action']) && $_POST['action'] == 'login') {
		try {
			if(Auth::login($_POST['username'], $_POST['password'])) {
				Response::redirect('/overview');
			} else {
				$errors[] = 'Login war fehlerhaft!';
			}
		} catch(\Exception $e) {
			$errors[] = $e->getMessage();
		}
	}

	$scope->getTemplate()->display('home', [
		'errors'	=> $errors
	]);
?>