<?php
	use \CTN\Utils;
	use \CTN\Database;
	use \CTN\PHPMailer;
	
	$template->getHeader();
?>
	<div class="container container-table">
		<div class="row vertical-center-row">
			<div class="col-sm-6">
				<div class="panel">
					<div class="panel-heading">
						<h5>Registrieren</h5>
					</div>
					<div class="panel-body">
						<form method="post" action="<?php print $template->getURL('/register'); ?>">
							<?php
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
								
								switch($step) {
									case 1:
										?>
										<fieldset class="row">
											<div class="form-group col-xs-12">
												<label for="username">Benutzername</label>
												<input id="username" class="form-control" type="text" placeholder="Gebe dein Benutzernamen ein" name="username" />
											</div>
											<div class="form-group col-xs-12">
												<label for="email">E-Mail Adresse</label>
												<input id="email" class="form-control" type="email" placeholder="Gebe deine E-Mail Adresse ein" name="email" />
											</div>
											<div class="form-group col-xs-12">
												<div class="checkbox">
													<label for="terms">
														<input id="terms" name="terms" type="checkbox" /> Ich akzeptiere die <a href="<?php print $template->getURL('/rules'); ?>" target="_blank">Regeln</a> von CrackTheNet.
													</label>
												</div>
										  </div>
											<div class="form-group col-xs-12" style="margin-bottom: 0px">
												<button class="btn btn-pimary btn-lg pull-right" type="submit" name="action" value="register" >Weiter</button>
											</div>
										</fieldset>
										<?php
									break;
									case 2:
										?>
										<p>Bitte wähle einen Kontinent aus, an dem du starten möchtest:</p>
										<svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="468pt" height="239pt" viewBox="0 0 468 239" preserveAspectRatio="xMidYMid meet">
										<?php
											$continents = Database::fetch('SELECT * FROM `' . DATABASE_PREFIX . 'continents`');
											
											foreach($continents AS $continent) {
												?>
													<g style="fill:<?php print $continent->svg_color; ?>; cursor: pointer;" id="<?php print $continent->id; ?>" transform="matrix(1.6963e-2,0,0,-1.6963e-2,0,239)">
														<title><?php print $continent->title; ?></title>
														<?php
															$json = json_decode($continent->svg_paths);
															
															foreach($json AS $entry) {
																?>
																<path d="<?php print $entry; ?>" style="fill:<?php print $continent->svg_color; ?>" />
																<?php
															}
														?>
													</g>
												<?php
											}
										?>
										</svg>
										<input type="hidden" name="step" value="<?php print $step; ?>" />
										<input type="hidden" name="continent" value="none" />
										<input type="hidden" name="action" value="register" />
										<script type="text/javascript">
											[].forEach.call(document.querySelectorAll('g'), function forEach(path) {
												path.addEventListener('click', function onClick() {
													document.querySelector('input[name="continent"]').value = this.id;
													document.querySelector('form').submit();
												});
											});
										</script>
										<?php
									break;
									case 3:
										?>
										<p>Bitte wähle ein Land aus, an dem du starten möchtest:</p>
										<?php
											$countries = Database::fetch('SELECT * FROM `' . DATABASE_PREFIX . 'countries` WHERE `continent`=:continent', [
												'continent' => $_SESSION['register']['continent']
											]);
											
											// @ToDo temporary display; Later: Build country SVG's!
											foreach($countries AS $countrie) {
												printf('<div data-path="true" id="%s">%s</div>', $countrie->id, $countrie->title);
											}
										?>
										<input type="hidden" name="step" value="<?php print $step; ?>" />
										<input type="hidden" name="country" value="none" />
										<input type="hidden" name="action" value="register" />
										<button type="submit" name="back" value="true">Zurück</button>
										<script type="text/javascript">
											[].forEach.call(document.querySelectorAll('[data-path]'), function forEach(path) {
												path.addEventListener('click', function onClick() {
													document.querySelector('input[name="country"]').value = this.id;
													document.querySelector('form').submit();
												});
											});
										</script>
										<?php
									break;
									case 4:
										$username	= $_SESSION['register']['username'];
										$email		= $_SESSION['register']['email'];
										$continent	= $_SESSION['register']['continent'];
										$country	= $_SESSION['register']['country'];
										
										if(isset($_SESSION['register']['status'])) {
											?>
											<p>Du bist bereits registriert.</p>
											<?php
										} else {
											$result		= Database::single('SELECT `' . DATABASE_PREFIX . 'countries`.`id` AS `country_id`,  `' . DATABASE_PREFIX . 'countries`.`title` AS `country`, `' . DATABASE_PREFIX . 'continents`.`title` AS `continent`, CONCAT(`' . DATABASE_PREFIX . 'continents`.`subnet`, ".", `' . DATABASE_PREFIX . 'countries`.`subnet`) AS `subnet` FROM `' . DATABASE_PREFIX . 'countries`, `' . DATABASE_PREFIX . 'continents` WHERE `' . DATABASE_PREFIX . 'countries`.`continent`=:continent AND `' . DATABASE_PREFIX . 'countries`.`id`=:country AND `' . DATABASE_PREFIX . 'continents`.`id`=:continent', [
												'continent'	=> $continent,
												'country'	=> $country
											]);
											
											// @ToDo check if country full (> 255)
											$computers		= Database::count('SELECT * FROM `' . DATABASE_PREFIX . 'computers` WHERE `country`=' . $result->country_id);
											$network_id		= $computers + 1;
											
											if($network_id <= 255) {
												$password	= Utils::generateString(16);
												$token		= Utils::getUUID('CTN', $username);
												$user_id	= Database::insert(DATABASE_PREFIX . 'users', [
													'id'				=> NULL,
													'username'			=> $username,
													'password'			=> hash('sha256', $password),
													'email'				=> $email,
													'verified_state'	=> 'UNVERIFIED',
													'verified_token'	=> $token,
													'locked_state'		=> 'UNLOCKED'
												]);
												
												
												$computer_id	= Database::insert(DATABASE_PREFIX . 'computers', [
													'id'			=> NULL,
													'name'			=> '',
													'ip_address'	=> sprintf('%s.%s', $result->subnet, $network_id),
													'user'			=> $user_id,
													'credits'		=> CREDITS_START,
													'points'		=> 0,
													'country'		=> $result->country_id
												]);
												
												$activation = $template->getURL('/activate/' . $token);
												
												$mail = new PHPMailer;
												$mail->setFrom('no-reply@crack-the-net.com', 'CrackTheNet.com');
												$mail->addAddress($email);
												$mail->isHTML(true);
												
												$_SESSION['register']['status'] = true;
												$mail->Subject = 'Registrierung auf CrackTheNet.';
												$mail->Body    = 'Hey, <strong>' . $username . '</strong>!<br /><br />Du hast dich ergolgreich auf CrackTheNet angemeldet. Hier sind deine Zugangsaten:<br /><br /><strong>Benutzername:</strong> ' . $username . '<br /><strong>Passwort:</strong> ' . $password . '<br /><br />Bevor Du Dich mit deinen Zugangsdaten einloggen kannst, musst du den Account aktivieren:<br /><a href="' . $activation . '">' . $activation . '</a>';
												$mail->AltBody = "Hey, " . $username . "!\r\n\r\nDu hast dich ergolgreich auf CrackTheNet angemeldet. Hier sind deine Zugangsaten:\r\n\r\nBenutzername: " . $username . "\r\nPasswort: " . $password . "\r\n\r\nBevor Du Dich mit deinen Zugangsdaten einloggen kannst, musst du den Account aktivieren:\r\n" . $activation;
												?>
												<p>Bald bist du ein Teil unseres Netzwerkes, <strong><?php print $username; ?></strong>!</p>
												<p>Deine Computer-Hardware steht bereits betriebsbereit in <strong><?php print $result->country; ?></strong> (137.<?php print sprintf('%s.%s', $result->subnet, $network_id); ?>) und wartet nur darauf, von dir genutzt zu werden.</p>
												<?php
													if($mail->send()) {
														?>
															<p><strong>Überprüfe</strong> nun dein <strong>E-Mail Postfach</strong> um deinen Account zu <strong>aktivieren</strong>.</p>
														<?php
													} else {
														?>
															<p><strong>ACHTUNG:</strong> Leider konnte die E-Mail mit der Aktivierung nicht versendet werden. Bitte probiere die "Passwort Vergessen?"-Funktion aus oder wende dich an unseren Support.</p>
														<?php
														//var_dump($mail->ErrorInfo);
													}
											} else {
												?>
												<p>Leider sind in <strong><?php print $result->country; ?></strong> bereits alle IP-Adressen vergeben.</p>
												<p>Wähle ein anderes Land, um dieses zu unterstützen.</p>
												<input type="hidden" name="step" value="<?php print $step; ?>" />
												<input type="hidden" name="action" value="register" />
												<button type="submit" name="back" value="true">Zurück</button>
												<?php
											}
										}
									break;
								}
							?>
						</form>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-5 col-md-offset-1 col-lg-4 col-lg-offset-2">
				<h1 class="section-title">Registriere dich jetzt!</h1>
				<p>In wenigen Schritten bist du schon dabei, einsatzbereit mit deinem ersten virtuellen Computer.</p>
			</div>
		</div>
	</div>
	<ctn-map>
		<canvas id="particles"></canvas>
	</ctn-map>
<?php
	$template->getFooter();
?>