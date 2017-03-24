<?php
	namespace CTN;
	
	class Routing {
		private $path			= '/';
		private $controller		= NULL;
		private $parameters		= [];
		
		public function __construct($path, $controller = NULL, $parameters = []) {
			$this->path			= $path;
			$this->controller	= $controller;
			
			foreach($parameters AS $parameter) {
				$this->setParameter($parameter, NULL);
			}
		}
		
		public function getPath() {
			return $this->path;
		}
		
		public function hasParameters() {
			return !(count($this->parameters) === 0);
		}
		
		public function getParameters() {
			return $this->parameters;
		}
		
		public function setParameter($name, $value) {
			return $this->parameters[$name] = $value;
		}
		
		public function updateParameter($index, $value) {
			$keys = array_keys($this->parameters);
			
			if(isset($keys[$index])) {
				return $this->parameters[$keys[$index]] = $value;
			}
			
			return null;
		}
		
		public function hasController() {
			return !($this->controller === NULL);
		}
		
		public function getController() {
			return $this->controller;
		}
	}
?>