<?php
	namespace CTN;
	
	class Utils {
		public static function filterName($name) {
			return preg_match('/^[a-zA-Z0-9_\-<>@\ \+]+$/', $name);
		}
		
		public static function filterBadwords($name) {
			$name = strtolower($name);
			$name = str_replace([
				'ä',
				'ö',
				'ü'
			], [
				'ae',
				'oe',
				'ue'
			], $name);
			
			$badwords_array = Database::fetch('SELECT * FROM `' . DATABASE_PREFIX . 'badwords`');
			$badwords_string = '';
			
			foreach($badwords_array AS $badword) {
				$badwords_string .= $badword->value;
				$badwords_string .= '|';
			}
			
			$badwords = rtrim($badwords_string, '|');
						
			return preg_match(sprintf('/(%s)/Uis', $badwords), $name);
		}
		
		public static function validateLength($string, $min, $max) {
			$length = mb_strlen($string);

			if($length < $min) {
				return -1;
			} else if($length > $max) {
				return 1;
			} else {
				return 0;
			}   
		}
		
		public static function getPost($name, $default = null) {
			if(isset($_POST[$name])) {
				return $_POST[$name];
			}
			
			return $default;
		}
		
		public static function getUUID($namespace, $name) {
			$nhex = str_replace(array('-','{','}'), '', $namespace);
			$nstr = '';
			
			for($i = 0; $i < strlen($nhex); $i +=2) {
				$a = $nhex[$i];
				$b = isset($nhex[$i + 1]) ? $nhex[$i + 1] : '';
				$nstr .= chr(hexdec($a . $b));
			}
			
			$hash = sha1($nstr . $name);
			
			return sprintf('%08s-%04s-%04x-%04x-%12s', substr($hash, 0, 8), substr($hash, 8, 4), (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000, (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000, substr($hash, 20, 12));
		}
		
		public static function generateString($length = 9, $add_dashes = false, $available_sets = 'luds') {
			$sets = [];
			$all = '';
			$password = '';
			
			if(strpos($available_sets, 'l') !== false)
				$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		
			if(strpos($available_sets, 'u') !== false)
				$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		
			if(strpos($available_sets, 'd') !== false)
				$sets[] = '23456789';
		
			if(strpos($available_sets, 's') !== false)
				$sets[] = '!@#$%&*?';
			
			foreach($sets as $set) {
				$password .= $set[array_rand(str_split($set))];
				$all .= $set;
			}
		
			$all = str_split($all);
		
			for($i = 0; $i < $length - count($sets); $i++)
				$password .= $all[array_rand($all)];
		
			$password = str_shuffle($password);
		
			if(!$add_dashes)
				return $password;
		
			$dash_len = floor(sqrt($length));
			$dash_str = '';
		
			while(strlen($password) > $dash_len) {
				$dash_str .= substr($password, 0, $dash_len) . '-';
				$password = substr($password, $dash_len);
			}
		
			$dash_str .= $password;
			
			return $dash_str;
		}
	}
?>