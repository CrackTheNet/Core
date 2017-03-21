<?php
	use \CTN\Database;
	$template->getHeader();

	$rules = Database::fetch('SELECT * FROM `' . DATABASE_PREFIX . 'rules`');
	$count = count($rules);
?>
	<div class="container">
		<div class="row">
			<div class="col-sm-6">
				<h1>Regeln</h1>
				<p>Jeder User, der sich für das Spiel registriert, verpflichtet sich, diese Regeln einzuhalten und Regelverstöße anderer zu melden.</p>
				<?php
					for($index = 0; $index < $count / 2; $index++) {
						$rule = $rules[$index];
						?>
							<h2 id="rules_<?php print ($index + 1); ?>"><strong>§<?php print ($index + 1); ?></strong> <?php print $rule->title; ?></h2>
							<p><?php print $rule->text; ?></p>
						<?php
					}
				?>
			</div>
			<div class="col-sm-6">				
				<br />
				<br />
				<br />
				<?php
					for(; $index < $count; $index++) {
						$rule = $rules[$index];
						?>
							<h2 id="rules_<?php print ($index + 1); ?>"><strong>§<?php print ($index + 1); ?></strong> <?php print $rule->title; ?></h2>
							<p><?php print $rule->text; ?></p>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	<ctn-map>
		<canvas id="particles"></canvas>
	</ctn-map>
<?php
	$template->getFooter();
?>