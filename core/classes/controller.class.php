<?php
	namespace CTN;
	
	class Controller {
		public static function get($file, $scope, $parameters = []) {
			foreach($parameters AS $name => $value) {
				${$name} = $value;
			}
			
			require_once(PATH . DS . 'core' . DS . 'controller' . DS . $file);
		}
	}
?>