<?php
	namespace CTN;

	use \CTN\Options;
	use \CTN\Auth;
	use \CTN\Messages;

	class Template {
		private $core;
		private $theme;
		private $charset = 'UTF-8';
		private $assigns = [];

		public function __construct($core) {
			$this->core			= $core;
			$this->theme		= new Theme(Options::get('THEME_DEFAULT'));

			if(Auth::isLoggedIn()) {
				$theme = Auth::getData('theme');
			
				if(!empty($theme)) {
					$this->theme	= new Theme($theme);
				}
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
			$this->assign('messages',		new Messages());

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

		public function getAdminHeader() {
			$this->getTemplate('admin/header', [
				'username'	=> Auth::getUsername()
			], true, true);
		}

		public function getAdminFooter() {
			$this->getTemplate('admin/footer', [], true, true);
		}

		public function getThemeURL($file) {
			return sprintf('%s://%s/%s/%s', ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https' : 'http'), $_SERVER['HTTP_HOST'], $this->theme->getURI(), $file);
		}

		public function getURL($path) {
			return sprintf('%s://%s%s', 'https', $_SERVER['HTTP_HOST'], $path);
		}

		public function getTitle() {
			return 'CrackTheNet | Browsergame | Let\'s hack the World!';
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
			if(substr($file, 0, 2) == '::') {
				return $this->getURL('/' . substr($file, 2));
			}

			if(preg_match('/^(http|https):\/\//Uis', $file)) {
				return $file;
			}

			return $this->getThemeURL($file);
		}

		private $css_async = false;

		public function includeCSS($files = [], $async = false, $compare = false) {
			$checksums			= [];
			$cache				= '';
			$this->css_async	= $async;

			foreach($files AS $file) {
				if($compare && file_exists(PATH . DS . 'temp/cache.js') && (filemtime(PATH . DS . 'temp/cache.js') > (time() - 60 * 5))) {
					$content		= file_get_contents($this->prepareFile($file));
					$checksum		= md5($content);
					$checksums[]	 = $checksum;

					$cache		.= '/* ' . $checksum . ' */';
					$cache		.= $content;
				} else {
					printf('<link rel="stylesheet" type="text/css" href="%s" />', $this->prepareFile($file));
				}
			}

			if($compare && file_exists(PATH . DS . 'temp/cache.js') && (filemtime(PATH . DS . 'temp/cache.js') > (time() - 60 * 5))) {
				file_put_contents(PATH . DS . 'temp/cache.css', $cache);
			}

			if($compare) {
				printf('<link rel="stylesheet" type="text/css" href="%s" />', $this->getURL('/cache.css'));
			}
		}

		public function includeJS($files = [], $footer = false, $async = false, $compare = false) {
			if(!$footer) {
				return;
			}

			if($this->css_async) {
				printf('<script type="text/javascript">try{includeCSS(\'%s\');}catch(e){}</script>', $this->getURL('/cache.css'));
			}

			$checksums	= [];
			$cache		= '';

			/* CSS Async*/
			$cache		.= '!function(e){"use strict";var n=function(n,t,o){function i(e){return f.body?e():void setTimeout(function(){i(e)})}var d,r,a,l,f=e.document,s=f.createElement("link"),u=o||"all";return t?d=t:(r=(f.body||f.getElementsByTagName("head")[0]).childNodes,d=r[r.length-1]),a=f.styleSheets,s.rel="stylesheet",s.href=n,s.media="only x",i(function(){d.parentNode.insertBefore(s,t?d:d.nextSibling)}),l=function(e){for(var n=s.href,t=a.length;t--;)if(a[t].href===n)return e();setTimeout(function(){l(e)})},s.addEventListener&&s.addEventListener("load",function(){this.media=u}),s.onloadcssdefined=l,l(function(){s.media!==u&&(s.media=u)}),s};"undefined"!=typeof exports?exports.includeCSS=n:e.includeCSS=n}("undefined"!=typeof global?global:this);';

			foreach($files AS $file) {
				if($compare && file_exists(PATH . DS . 'temp/cache.js') && (filemtime(PATH . DS . 'temp/cache.js') > (time() - 60 * 5))) {
					$content		= file_get_contents($this->prepareFile($file));
					$checksum		= md5($content);
					$checksums[]	 = $checksum;

					$cache		.= '/* ' . $checksum . ' */';
					$cache		.= 'try{';
					$cache		.= $content;
					$cache		.= '}catch(e){}';
				} else {
					printf('<script ' . ($async ? 'async ' : '') . 'type="text/javascript" src="%s"></script>', $this->prepareFile($file));
				}
			}

			if($compare && file_exists(PATH . DS . 'temp/cache.js') && (filemtime(PATH . DS . 'temp/cache.js') > (time() - 60 * 5))) {
				file_put_contents(PATH . DS . 'temp/cache.js', $cache);
			}

			if($compare) {
				printf('<script ' . ($async ? 'async ' : '') . 'type="text/javascript" src="%s"></script>', $this->getURL('/cache.js'));
			}
		}

		public function display($file, $arguments = []) {
			$this->getTemplate($file, $arguments, true, true);
		}
	}
?>
