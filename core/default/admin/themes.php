<?php
	$template->getAdminHeader();
	?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3>Themes</h3>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<?php
						print_r($themes);
					?>
				</div>
			</div>
		</div>
	<?php
	$template->getAdminFooter();
?>