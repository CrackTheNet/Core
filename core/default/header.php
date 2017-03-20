<!DOCTYPE html>
<html lang="<?php print $template->getLanguage(true); ?>">
	<head>
		<title><?php print $template->getTitle(); ?></title>
		<meta charset="<?php print $template->getCharset(); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php
			$template->includeCSS();
			$template->includeJS();
		?>
	</head>
	<body>