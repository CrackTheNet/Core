<?php	
	namespace CTN;
	
	class ResponseFactory {
		private static $instance	= NULL;
		private $headers			= [
			'Content-Type'	=> 'text/html; charset=UTF-8'
		];
		
		public static function getInstance() {
			if(self::$instance === NULL) {
				self::$instance = new self();
			}
			
			return self::$instance;
		}
	
		private function __construct() {
			/* do Nothing */
		}
		
		public function addHeader($name, $value) {
			$this->headers[$name] = $value;
		}
		
		public function header() {
			if(count($this->headers) > 0) {
				foreach($this->headers AS $name => $value) {
					header(sprintf('%s: %s', $name, $value));
				}
			}
		}
		
		public function redirect($url) {
			$this->addHeader('Location', SITE_URL . $url);
			$this->header();
			exit();
		}
	}
	
	class Response {
		public static function addHeader($name, $value) {
			ResponseFactory::getInstance()->addHeader($name, $value);
		}
		
		public static function header() {
			ResponseFactory::getInstance()->header();
		}
		
		public static function redirect($url) {
			ResponseFactory::getInstance()->redirect($url);
		}
	}
?>