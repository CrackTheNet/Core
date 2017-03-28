<?php
	namespace CTN;
	
	class Session {
		public static function init() {
			if(!isset($_SESSION)) {
				session_save_path(PATH . DS . 'temp');
				session_start();
			}
		}
		
		public static function get($name) {
			self::init();
			
			if(isset($_SESSION[$name])) {
				return $_SESSION[$name];
			}
			
			return NULL;
		}
		
		public static function set($name, $value) {
			self::init();
			
			$_SESSION[$name] = $value;
		}
		
		public static function remove($name) {
			self::init();
			
			$_SESSION[$name] = NULL;
			unset($_SESSION[$name]);
		}
	}
?>