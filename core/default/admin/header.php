<!DOCTYPE html>
<html lang="<?php print $template->getLanguage(true); ?>">
	<head>
		<title><?php print $template->getTitle(); ?></title>
		<meta charset="<?php print $template->getCharset(); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<?php
			$template->includeCSS([
				'::css/bootstrap.min.css'
			]);
			$template->includeJS();
		?>
		<style>
			html {
				height: 100%;
				min-height: 100%;
			}
			
			* {
				-webkit-border-radius: 0px !important;
				border-radius: 0px !important;
			}
			
			body {
				background: #082648;
				font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
				color: #FFF;
				height: 100%;
				min-height: 100%;
				font-size: 12px;
			}
			
			aside {
				float: left;
				width: 230px;
				height: 100%;
				padding-right: 1px;
			}
			
			aside picture {
				float: left;
				background: rgba(0,0,0,0.4);
				width: 100%;
				margin-bottom: 1px;
				background: url(../assets/logo.png) center top no-repeat transparent;
				background-size: 100% auto;
				height: 90px;
				margin: 10px 0px;
			}
			
			section {
				background: #F0F0F0;
				color: #333;
				margin-left: 230px;
				padding-top: 10px;
				min-height: 100%;
			}
			
			section h3 {
				margin: 0;
				padding: 0;
			}
			
			aside nav {
				float: left;
				background: rgba(0,0,0,0.4);
				width: 100%;
				margin-bottom: 1px;	
			}
			
			aside nav.search {
			    padding: 0px;
				background: none;	
			}
			
			aside nav.navbar {
				margin-bottom: 0px;
			}
			
			aside nav.navbar ul {
				display: block;
				float: left;
				width: 100%;
				list-style: none;
				padding: 0px;
				margin: 0px;
			}
			
			aside nav.navbar li {
			    float: left;
				width: 100%;
				font-size: 12px;
				color: #FFF;	
			}
			
			aside nav.navbar li a {
			     padding: 10px 20px 10px 15px;
				float: left;
				display: block;
				width: 100%;
				position: relative;
				line-height: 15px;
				
				padding-left: 35px;
				background: rgba(0,0,0,0.2);
				margin-bottom: 1px;
			}
			
			aside nav span.name {
				font-size: 11px;
				color: #FFF;
				font-weight: bold;
				float: left;
				line-height: 35px;
				height: 35px;
				padding-left: 10px;
			}
			
			.form-control {
				padding: 6px 12px;
				font-size: 12px;
				height: 30px;
			}

			.form-control, input, select, select[multiple], textarea {
				background: rgba(0,0,0,0.2);
				border-color: transparent;
				color: #FFF;
			}
		</style>
	</head>
	<body>
		<aside>
			<picture></picture>
			<nav>
				<span class="name">Hallo, <strong><?php print $username; ?></strong>!</span>
			</nav>
			<nav class="search">
				<div class="input-group">             
					<input type="text" class="form-control" placeholder="Search..." />
					<div class="input-group-addon"><span class="icon-search"></span></div>
				</div>
			</nav>
			<nav class="navbar">
				<ul>
					<li><a href="<?php print $template->getURL('/admin/users'); ?>">Benutzer</a></li>
					<li><a href="<?php print $template->getURL('/admin/themes'); ?>">Theme</a></li>
					<li><a href="<?php print $template->getURL('/admin/plugins'); ?>">Plugins</a></li>
					<li><a href="<?php print $template->getURL('/admin/system'); ?>">System</a></li>
				</ul>
			</nav>
		</aside>
		<section>