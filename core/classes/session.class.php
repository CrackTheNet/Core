<?php
	namespace CTN;
	
	class Session {
		public function init() {
			if(!isset($_SESSION)) {
				session_save_path(PATH . '/temp');
				session_start();
			}
		}
		
		public function get($name) {
			self::init();
			
			if(isset($_SESSION[$name])) {
				return $_SESSION[$name];
			}
			
			return NULL;
		}
		
		public function set($name, $value) {
			self::init();
			
			$_SESSION[$name] = $value;
		}
		
		public function remove($name) {
			self::init();
			
			$_SESSION[$name] = NULL;
			unset($_SESSION[$name]);
		}
	}
?>