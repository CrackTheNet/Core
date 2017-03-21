<?php
	namespace CTN;
	
	use \CTN\Database;
	use \CTN\Auth;
	use \CTN\Routing;
	
	class Core {
		private $router;
		private $template;
		
		public function __construct() {
			if(!isset($_SESSION)) {
				session_start();
			}
			
			// Autoloading
			spl_autoload_register([ $this, 'load' ]);
			
			$this->router		= new Router($this);
			$this->template		= new Template($this);
			
			$this->init();
		}
		
		public function getTemplate() {
			return $this->template;
		}
		
		public function getRouter() {
			return $this->router;
		}
		
		private function load($class) {			
			if(file_exists(PATH . DS . 'core' . DS . 'config.php')) {
				require_once(PATH . DS . 'core' . DS . 'config.php');
			}
		
			$file			= trim($class, '\\');		// remove prefix-backslashes
			$file_array		= explode('\\', $file);
			
			array_shift($file_array);					// remove root namespace
			array_unshift($file_array, 'core/classes');	// add root directory
			
			$file			= implode(DS, $file_array);
			$path			= PATH . DS . strtolower($file . '.class.php');

			if(file_exists($path)) {
				require_once($path);
			}
		}
		
		private function init() {
			foreach([
				new Routing('/', 'home.php'),
				new Routing('/login', 'login.php'),
				new Routing('/register', 'register.php'),
				new Routing('/help', 'help.php'),
				new Routing('/rules', 'rules.php'),
				new Routing('/imprint', 'imprint.php'),
				new Routing('/logout', 'logout.php'),
				new Routing('/overview', 'user/overview.php'),
				new Routing('^/activate/([a-zA-Z0-9\-]+)$', 'activate.php', [ 'token' ])
			] AS $routing) {
				$this->getRouter()->addRoute($routing->getPath(), function() use ($routing) {
					$arguments = func_get_args();
						
					if($routing->hasController()) {
						foreach($arguments AS $index => $argument) {
							$routing->updateParameter($index, $argument);
						}
						
						Controller::get($routing->getController(), $this, $routing->getParameters());
					}
				});
			}
			
			$this->router->run();
		}
	}
?>