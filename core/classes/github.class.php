<?php
	namespace CTN;
	
	class GitHub {
		protected static $cache			= true;
		protected static $api_secured	= true;
		protected static $api_endpoint	= 'api.github.com';
		protected static $company		= 'CrackTheNet';
		protected static $respository	= 'Core';
		
		protected static function getAPI($path = '') {
			return sprintf('%s://%s%s', self::$api_secured ? 'https' : 'http', self::$api_endpoint, str_replace([
				'{$owner}',
				'{$repository}'
			], [
				self::$company,
				self::$respository
			], $path));
		}
		
		protected static function callAPI($path = '') {
			$url = self::getAPI($path);
			
			if(self::$cache && file_exists(PATH . DS . 'temp/Commits.GitHub')) {
				return json_decode(file_get_contents(PATH . DS . 'temp/Commits.GitHub'));
			}
			
			$http = curl_init(); 
            curl_setopt($http, CURLOPT_URL, $url);
            curl_setopt($http, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($http, CURLOPT_USERAGENT, sprintf('%s v%s', self::$company, VERSION));
            $content = curl_exec($http); 
            curl_close($http); 
			
			if(self::$cache) {
				file_put_contents(PATH . DS . 'temp/Commits.GitHub', $content);
			}
			
			return json_decode($content);
		}
		
		public static function getCommits() {
			return self::callAPI('/repos/{$owner}/{$repository}/commits');
		}
	}
?>