<?php
	$template->getHeader();
?>
<div class="col-sm-6">
	<h1><?php print $title; ?></h1>
	<p><?php print $description; ?></p>
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
<?php
	$template->getFooter();
?>