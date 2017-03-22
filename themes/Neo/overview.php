<?php
	$template->getHeader();
	?>
		<div class="col-sm-12">
			<h1 class="section-title">Übersicht</h1>
			
			<div class="bg-box bg-danger text-danger">
				<strong>ACHTUNG:</strong>
				<br />Du hast dich bei deinem letzten Besuch nicht ausgeloggt!
				<br />Dies könnte zur Folge haben, dass dein Account in fremde Hände geraten kann und die Online/Offline-Anzeige verfälschen kann.
			</div>
			
			<blockquote>
				<img class="pull-left" style="width: 80px;" src="<?php print $template->getURL('/assets/computer.png'); ?>" alt="Computer" />
				<h3>Computer</h3>
				<footer>Auf 1 Computer läuft im Moment kein Upgrade; hier solltest du eventuell ein neues Upgrade starten.</footer>
			</blockquote>
			
			<blockquote>
				<img class="pull-left" style="width: 80px;" src="<?php print $template->getURL('/assets/statistics.png'); ?>" alt="Statistiken" />
				<h3>Situation</h3>
				<footer>Du besitzt im Moment 12 Punkte, aufgeteilt auf 1 Computer. Damit bist du auf dem 463. Platz in der Gesamtwertung.</footer>
			</blockquote>
		</div>
	<?php
	$template->getFooter();
?>