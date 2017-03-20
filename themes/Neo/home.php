<?php
	$template->getHeader();
?>
	<div class="container  container-table">
		<div class="row vertical-center-row">
			<div class="col-sm-6">
				<h1 class="section-title">Let's hack the World!</h1>
				<p>Willkommen bei dem Browsergame "Crack The Net".</p>
				<p>CrackTheNet ist ein browserbasiertes Onlinespiel. Ihr bekommt einen Computer in einem virtuellen (nicht existenten) Netzwerk zugewiesen. Entwickelt euren Prozessor und andere Items weiter und verdient Geld. Bald seid Ihr soweit dass Ihr Waffen Viren Trojaner etc entwickeln und gegen eure Feinde einsetzen könnt.</p>
				<div class="btn-wrap">
					<a class="btn btn-lg btn-default" href="<?php print $template->getURL('/register'); ?>">Jetzt registrieren!<span class="icon ti-arrow-circle-down"></span></a>
				</div>
			</div>
			<div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-2">
				<div class="panel">
					<div class="panel-heading">
						<h5>Login</h5>
					</div>
					<div class="panel-body">
						<form method="post" action="<?php print $template->getURL('/login'); ?>">
							<?php
								if(isset($activated) && $activated) {
									?>
									<div class="bg-box bg-info text-info">
										Dein Account wurde erfolgreich aktiviert.
									</div>
									<?php
								}
								
								if(!empty($errors)) {
									?>
									<div class="bg-box bg-danger text-danger">
										Bitte überprüfe folgende Eingaben:
										<ul class="square">
											<?php
												foreach($errors AS $name => $message) {
													printf('<li><span>%s</span></li>', $message);
												}
											?>
										</ul>
									</div>
									<?php
								}
							?>
							<fieldset class="row">
								<div class="form-group col-xs-12">
									<label for="username">Benutzername</label>
									<input id="username" class="form-control" type="text" placeholder="Gebe dein Benutzernamen ein" name="username" />
								</div>
								<div class="form-group col-xs-12">
									<label for="password">Passwort</label>
									<input id="password" class="form-control" type="password" placeholder="Gebe dein Passwort ein" name="password" />
								</div>
								<div class="form-group col-xs-12" style="margin-bottom: 0px">
									<button class="btn btn-pimary btn-block btn-lg" name="action" value="login" type="submit">Einloggen</button>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<ctn-map>
		<canvas id="particles"></canvas>
	</ctn-map>
<?php
	$template->getFooter();
?>