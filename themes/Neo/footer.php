<?php
	use \CTN\Auth;
	?>
		</div>
		<ctn-map>
			<canvas id="particles"></canvas>
		</ctn-map>
		<?php			
			$template->includeJS([
				'js/Polyfill.min.js',
				'js/ol.min.js',
				'js/jQuery.min.js',
				'js/bootstrap.min.js',
				'js/Header.js',
				'js/Background.js'
			], true);
		?>
	</body>
</html>