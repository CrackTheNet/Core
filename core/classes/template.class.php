<?php
	namespace CTN;
	
	use \CTN\Options;
	use \CTN\Auth;
	
	class Template {
		private $core;
		private $theme;
		private $charset = 'UTF-8';
		private $assigns = [];
		
		public function __construct($core) {
			$this->core			= $core;
			$this->theme		= new Theme(Options::get('THEME_DEFAULT'));
			
			if(Auth::isLoggedIn()) {
				$this->theme	= new Theme(Auth::getData('theme'));			
			}
			
			ob_start('ob_gzhandler');
		}
		
		public function assign($name, $value) {
			$this->assigns[$name] = $value;
		}
		
		private function getTemplate($file, $arguments = [], $assignments = true, $scope = true) {
			foreach($arguments AS $name => $value) {
				${$name} = $value;
			}
			
			$this->assign('template',		$file);
			$this->assign('current_page',	$this->core->getRouter()->getPage());
			
			if($assignments) {
				foreach($this->assigns AS $name => $value) {
					${$name} = $value;
				}
			}
			
			if($scope) {
				$template = $this;
			}
			
			if(file_exists($this->theme->getPath() . DS . $file . '.php')) {
				require_once($this->theme->getPath() . DS . $file . '.php');
			} else if(file_exists($this->theme->getPath() . DS . 'index.php')) {
				require_once($this->theme->getPath() . DS . 'index.php');				
			} else {
				require_once(PATH . DS . 'core' . DS . 'default' . DS . $file . '.php');
			}
		}
		
		public function getHeader() {
			$this->getTemplate('header', [], true, true);
		}
		
		public function getFooter() {
			$this->getTemplate('footer', [], true, true);
		}
		
		public function getThemeURL($file) {
			return sprintf('%s://%s/%s/%s', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http'), $_SERVER['HTTP_HOST'], $this->theme->getURI(), $file);
		}
		
		public function getURL($path) {
			return sprintf('%s://%s%s', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http'), $_SERVER['HTTP_HOST'], $path);
		}
		
		public function getTitle() {
			return 'Title';
		}
		
		public function getCharset() {
			return $this->charset;
		}
		
		public function getLanguage($short = false) {
			if($short) {
				return 'en';
			}
			
			return 'en_US';
		}
		
		private function prepareFile($file) {
			if(preg_match('/^(http|https):\/\//Uis', $file)) {
				return $file;
			}
			
			return $this->getThemeURL($file);;
		}
		
		public function includeCSS($files = []) {
			foreach($files AS $file) {
				printf('<link rel="stylesheet" type="text/css" href="%s" />', $this->prepareFile($file));
			}
		}
		
		public function includeJS($files = [], $footer = false) {
			foreach($files AS $file) {
				printf('<script type="text/javascript" src="%s"></script>', $this->prepareFile($file));
			}
			
			if($footer) {
				?><script type="text/javascript">var _paq = _paq || [];_paq.push(["setDocumentTitle",document.domain + "/" + document.title]);_paq.push(["setCookieDomain", "*.*"]);_paq.push(['trackPageView']);_paq.push(['enableLinkTracking']);(function(){var u="//track.crack-the-net.com/";_paq.push(['setTrackerUrl',u+'piwik.php']);_paq.push(['setSiteId','2']);var d=document,g=d.createElement('script'),s=d.getElementsByTagName('script')[0];g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);})();</script><noscript><p><img src="//track.crack-the-net.com/piwik.php?idsite=2&rec=1" style="border:0;" alt="" /></p></noscript><?php
			}
		}
		
		public function display($file, $arguments = []) {
			$this->getTemplate($file, $arguments, true, true);
		}
	}
?>