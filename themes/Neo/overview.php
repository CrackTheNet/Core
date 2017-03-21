<?php
	$template->getHeader();
?>
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h1 class="section-title">Übersicht</h1>
				<a href="<?php print $template->getURL('/logout'); ?>">Logout</a>
			</div>
		</div>
	</div>
	<ctn-map>
		<canvas id="particles"></canvas>
	</ctn-map>
<?php
	$template->getFooter();
?>