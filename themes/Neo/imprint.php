<?php
	use \CTN\Options;
	
	$template->getHeader();
?>
	<div class="col-sm-6">
		<h1>Impressum</h1>
		<p>Crack the Net | Das Browsergame</p>
		<ul class="square">
			<li><span><?php print Options::get('IMPRINT_NAME'); ?></span></li>
			<li><span><?php print Options::get('IMPRINT_ADDRESS'); ?></span></li>
			<li><span><?php print Options::get('IMPRINT_CITY'); ?></span></li>
		</ul>
		<br />
		<ul class="square">
			<li><strong>E-Mail</strong> <span><?php print Options::get('IMPRINT_EMAIL'); ?></span></li>
			<li><strong>Telefon</strong> <span><?php print Options::get('IMPRINT_TELEPHONE'); ?></span></li>
		</ul>
		
		<h1>Haftungsausschluss</h1>
		
		<h2>Haftung für Inhalte</h2>
		<p>Die Inhalte unserer Seiten wurden mit größter Sorgfalt erstellt. Für die Richtigkeit, Vollständigkeit und Aktualität der Inhalte können wir jedoch keine Gewähr übernehmen. Als Diensteanbieter sind wir gemäß § 7 Abs.1 TMG für eigene Inhalte auf diesen Seiten nach den allgemeinen Gesetzen verantwortlich. Nach §§ 8 bis 10 TMG sind wir als Diensteanbieter jedoch nicht verpflichtet, übermittelte oder gespeicherte fremde Informationen zu überwachen oder nach Umständen zu forschen, die auf eine rechtswidrige Tätigkeit hinweisen. Verpflichtungen zur Entfernung oder Sperrung der Nutzung von Informationen nach den allgemeinen Gesetzen bleiben hiervon unberührt. Eine diesbezügliche Haftung ist jedoch erst ab dem Zeitpunkt der Kenntnis einer konkreten Rechtsverletzung möglich. Bei Bekanntwerden von entsprechenden Rechtsverletzungen werden wir diese Inhalte umgehend entfernen.</p>
	</div>
	<div class="col-sm-6">				
		<h2>Haftung für Links</h2>
		<p>Unser Angebot enthält Links zu externen Webseiten Dritter, auf deren Inhalte wir keinen Einfluss haben. Deshalb können wir für diese fremden Inhalte auch keine Gewähr übernehmen. Für die Inhalte der verlinkten Seiten ist stets der jeweilige Anbieter oder Betreiber der Seiten verantwortlich. Die verlinkten Seiten wurden zum Zeitpunkt der Verlinkung auf mögliche Rechtsverstöße überprüft. Rechtswidrige Inhalte waren zum Zeitpunkt der Verlinkung nicht erkennbar. Eine permanente inhaltliche Kontrolle der verlinkten Seiten ist jedoch ohne konkrete Anhaltspunkte einer Rechtsverletzung nicht zumutbar. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Links umgehend entfernen.</p>
		
		<h2>Urheberrecht</h2>
		<p>Die durch die Seitenbetreiber erstellten Inhalte und Werke auf diesen Seiten unterliegen dem deutschen Urheberrecht. Die Vervielfältigung, Bearbeitung, Verbreitung und jede Art der Verwertung außerhalb der Grenzen des Urheberrechtes bedürfen der schriftlichen Zustimmung des jeweiligen Autors bzw. Erstellers. Downloads und Kopien dieser Seite sind nur für den privaten, nicht kommerziellen Gebrauch gestattet. Soweit die Inhalte auf dieser Seite nicht vom Betreiber erstellt wurden, werden die Urheberrechte Dritter beachtet. Insbesondere werden Inhalte Dritter als solche gekennzeichnet. Sollten Sie trotzdem auf eine Urheberrechtsverletzung aufmerksam werden, bitten wir um einen entsprechenden Hinweis. Bei Bekanntwerden von Rechtsverletzungen werden wir derartige Inhalte umgehend entfernen.</p>
	
		<h2>Copyright</h2>
		<p>Diese CrackTheNet-Version steht unter OpenSource und wurde von <a href="https://www.Crack-the-Net.com/">https://www.Crack-the-Net.com/</a> heruntergeladen.</p>
	</div>
<?php
	$template->getFooter();
?>