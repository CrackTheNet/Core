<?php
	namespace CTN;
	
	class Core {
		private $router;
		
		public function __construct() {
			// Autoloading
			spl_autoload_register([ $this, 'load' ]);
			
			$this->router		= new Router($this);
			
			$this->init();
		}
		
		public function getRouter() {
			return $this->router;
		}
		
		private function load($class) {
			if(file_exists(PATH . DS . 'config.php')) {
				require_once(PATH . DS . 'config.php');
			}
		
			$file				= trim($class, '\\');				// remove prefix-backslashes
			$file_array		= explode('\\', $file);
			
			array_shift($file_array);							// remove root namespace
			array_unshift($file_array, 'core/classes');	// add root directory
			
			$file				= implode(DS, $file_array);
			$path			= PATH . DS . strtolower($file . '.class.php');

			if(file_exists($path)) {
				require_once($path);
			}
		}
		
		private function init() {
			// Create routes
			$this->getRouter()->addRoute('/', function() {
				print "Home";
			});
			
			$this->getRouter()->addRoute('/login', function() {
				print "Login";
			});
			
			$this->getRouter()->addRoute('/register', function() {
				print "Register";
			});
			
			$this->getRouter()->addRoute('/help', function() {
				print "Help";
			});
			
			$this->router->run();
		}
	}
?>