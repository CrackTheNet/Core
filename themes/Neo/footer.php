<?php
	use \CTN\Auth;
	?>
		</div>
		<ctn-map>
			<canvas id="particles"></canvas>
		</ctn-map>
		<?php			
			$template->includeJS([
				'https://cdn.polyfill.io/v2/polyfill.min.js?features=requestAnimationFrame,Element.prototype.classList,URL',
				'https://openlayers.org/en/v4.0.1/build/ol.js',
				'https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js',
				'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
				'js/Header.js',
				'js/Background.js'
			], true);
		?>
	</body>
</html>