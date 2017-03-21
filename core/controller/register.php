<?php
	use \CTN\Auth;
	use \CTN\Response;
	use \CTN\Utils;
	use \CTN\Database;
	
	if(Auth::isLoggedIn()) {
		Response::redirect('/overview');
	}
	
	$errors	= [];
	$step	= Utils::getPost('step', 1);
	
	if(isset($_POST['action']) && Utils::getPost('action') == 'register') {
		if(isset($_SESSION['register']['status'])) {
			Response::redirect('/login');
			return;
		}
		
		switch($step) {
			case 1:
				$username	= Utils::getPost('username');
				$email		= Utils::getPost('email');
				$length		= Utils::validateLength($username, 4, 20);
				
				if(!isset($_POST['terms'])) {
					$errors['terms'] = 'Bitte akzeptiere die Nutzungsbedingungen/Regeln!';
				}
				
				if(empty($username)) {
					$errors['username'] = 'Bitte gebe ein Benutzername an!';
				} else if($length == -1) {
					$errors['username'] = 'Der Benutzername ist zu kurz! Bitte verwende einen Namen von <strong>4 bis 20</strong> Zeichen!';
				} else if($length == 1) {
					$errors['username'] = 'Der Benutzername ist zu lang! Bitte verwende einen Namen von <strong>4 bis 20</strong> Zeichen!';
				} else if(Utils::filterBadwords($username)) {
					$errors['username'] = 'Der Benutzername enthält verbotene Teile!';
				} else if(!Utils::filterName($username)) {
					$errors['username'] = 'Der Benutzername darf nur aus folgenden Zeichen bestehen: <strong>Buchstaben</strong> (von A bis Z), <strong>Zahlen</strong> (von 0 bis 9) und folgende <strong>Sonderzeichen</strong> (+, -, _, @, &lt;, &gt;) sowie <strong>Leerzeichen</strong>.';
				} else if(Database::count('SELECT `id` FROM `' . DATABASE_PREFIX . 'users` WHERE `username`=\'' . $username . '\'') > 0) {
					$errors['username'] = 'Der Benutzername <strong>existiert bereits</strong>.';
				}
				
				if(empty($email)) {
					$errors['email'] = 'Bitte gebe eine E-Mail Adresse an!';
				} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errors['email'] = 'Bitte gebe eine gültige E-Mail Adresse an!';
				} else if(Database::count('SELECT `id` FROM `' . DATABASE_PREFIX . 'users` WHERE `email`=\'' . $email . '\'') > 0) {
					$errors['email'] = 'Die E-Mail Adresse wird <strong>wird bereits verwendet</strong>. Du darfst nur <strong>einen Account</strong> registrieren!';
					// @ToDo Flag user for rulebreaking
				}
				
				if(count($errors) == 0) {
					$_SESSION['register']					= [];
					$_SESSION['register']['username']		= $username;
					$_SESSION['register']['email']			= $email;
					++$step;
				}
			break;
			case 2:
				if(isset($_POST['back']) && Utils::getPost('back') == 'true') {
					--$step;
				} else {
					$continent	= Utils::getPost('continent');
					
					if(empty($continent)) {
						$errors['continent'] = 'Bitte wähle einen gültigen Kontinent aus!';
					}
					
					// @ToDo validate Continent by ID??
					
					if(count($errors) == 0) {
						$_SESSION['register']['continent']	= $continent;
						++$step;
					}
				}
			break;
			case 3:
				if(isset($_POST['back']) && Utils::getPost('back') == 'true') {
					--$step;
				} else {
					$country	= Utils::getPost('country');
					
					if(count($errors) == 0) {
						$_SESSION['register']['country']	= $country;
						++$step;
					}
				}
			break;
			case 4:
				if(isset($_POST['back']) && Utils::getPost('back') == 'true') {
					--$step;
				}
			break;
		}
	}
	
	$scope->getTemplate()->display('register', [
		'errors'	=> $errors,
		'step'		=> $step
	]);
?>