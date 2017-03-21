<?php
	namespace CTN;
	
	use \CTN\Database;
	
	class Options {
		public static function get($key) {
			$result = Database::single('SELECT `value` FROM `' . DATABASE_PREFIX . 'options` WHERE `key`=:key', [
				'key'	=> $key
			]);
			
			return $result->value;
		}
	}
?>