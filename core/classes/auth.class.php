<?php
	namespace CTN;
	use \CTN\Session;
	
	class AuthFactory {
		private static $instance = NULL;
		
		public static function getInstance() {
			if(self::$instance === NULL) {
				self::$instance = new self();
			}
			
			return self::$instance;
		}
		
		public function isLoggedIn() {
			$user_id	= Session::get('user_id');
			$login		= (!empty($user_id) && $user_id > 0);
			
			// Update activity
			if($login) {
				Database::update(DATABASE_PREFIX . 'users', 'id', [
					'id'				=> $user_id,
					'time_activity'		=> date('Y-m-d H:i:s'),
					'security_logout'	=> 'N'
				]);
			}
		
			return $login;
		}
		
		public function getID() {
			return Session::get('user_id');
		}
		
		public function getUsername() {
			return Session::get('user_name');
		}
		
		public function logout() {
			Database::update(DATABASE_PREFIX . 'users', 'id', [
				'id'				=> $this->getID(),
				'time_activity'		=> date('Y-m-d H:i:s'),
				'security_logout'	=> 'Y'
			]);
			
			Session::remove('user_id');
			Session::remove('user_name');
		}
		
		public function hadLoggedOut() {
			return Session::get('security_logout');
		}
		
		public function login($username, $password) {
			$result = Database::single('SELECT * FROM `' . DATABASE_PREFIX . 'users` WHERE `username`=:username AND `password`=:password LIMIT 1', array(
				'username'	=> $username,
				'password'	=> hash('sha256', $password)
			));
			
			if($result == false) {
				throw new \Exception('Unknown User');
				return false;
			}
			
			if($result->id > 0) {
				Session::set('user_name',		$result->username);
				Session::set('user_id',			$result->id);
				Session::set('security_logout', $result->security_logout);
			} else {
				throw new \Exception('Unknown User');
				return false;				
			}
			
			return true;
		}
		
		public function getData($name) {
			$result = Database::single('SELECT * FROM `' . DATABASE_PREFIX . 'users` WHERE `id`=:user_id LIMIT 1', array(
				'user_id'	=> $this->getID()
			));
			
			if($result == false) {
				return null;
			}
			
			return $result->{$name};
		}
	}
	
	class Auth {
		public static function isLoggedIn() {
			return AuthFactory::getInstance()->isLoggedIn();
		}
		
		public static function login($username, $password) {
			return AuthFactory::getInstance()->login($username, $password);
		}
		
		public static function logout() {
			return AuthFactory::getInstance()->logout();
		}
		
		public static function getID() {
			return AuthFactory::getInstance()->getID();
		}
		
		public static function getUsername() {
			return AuthFactory::getInstance()->getUsername();
		}
		
		public static function hadLoggedOut() {
			return AuthFactory::getInstance()->hadLoggedOut();
		}
		
		public static function getData($name) {
			return AuthFactory::getInstance()->getData($name);
		}
	}
?>