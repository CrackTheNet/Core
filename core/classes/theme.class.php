<?php
	namespace CTN;
	
	class Theme {
		private $directory = '';
		
		public function __construct($directory) {
			$this->directory = $directory;
		}
		
		public function getPath() {
			return PATH . DS . 'themes' . DS . $this->directory;
		}
		
		public function getURI() {
			return 'themes' . DS . $this->directory;
		}
	}
?>