<!DOCTYPE html>
<html lang="<?php print $template->getLanguage(true); ?>">
	<head>
		<title><?php print $template->getTitle(); ?></title>
		<meta charset="<?php print $template->getCharset(); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="icon" type="image/png" href="<?php print $template->getThemeURL('assets/icon.png'); ?>" />
		<?php
			$template->includeCSS([
				'https://fonts.googleapis.com/css?family=Roboto:300,400,500,700',
				'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
				'https://openlayers.org/en/v4.0.1/css/ol.css',
				'css/style.css'
			]);
			
			$template->includeJS();
		?>
	</head>
	<body>
		<header>
			<nav class="navbar navbar-default navbar-fixed-top navbar-transparent">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle-icon navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon ti-layout-grid3-alt"></span>
						</button>
						<a class="navbar-brand" href="<?php print $template->getURL('/'); ?>">
							<img src="<?php print $template->getThemeURL('assets/logo.png'); ?>" alt="" />
						</a>
					</div>
					<div class="collapse navbar-collapse" id="navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li class="active"><a href="<?php print $template->getURL('/login'); ?>">Login</a></li>
							<li><a href="<?php print $template->getURL('/register'); ?>">Registrieren</a></li>
							<li><a href="<?php print $template->getURL('/rules'); ?>">Regeln</a></li>
							<li><a href="<?php print $template->getURL('/help'); ?>">Hilfe</a></li>
							<li><a href="<?php print $template->getURL('/imprint'); ?>">Impressum</a></li>
						</ul>
					</div>
				</div>
			</nav>
		</header>