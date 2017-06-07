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
	
	$themes = [];
	$themes_path = PATH . DS . 'themes' . DS;
	$directorys = scandir($themes_path);
	
	foreach($directorys AS $directory) {
		if(in_array($directory, [ '.', '..' ])) {
			continue;
		}
		
		if(file_exists($themes_path . $directory . DS . 'theme.json')) {
			$theme				= json_decode(file_get_contents($themes_path . $directory . DS . 'theme.json'));
			$theme->screenshot	= file_exists($themes_path . $directory . DS . 'screenshot.png');
			$theme->path		= $themes_path . $directory . DS;
			$themes[$directory]	= $theme;
		}
	}
	
	$scope->getTemplate()->display('admin/themes', [
		'themes'	=> $themes
	]);
?>